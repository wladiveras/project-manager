<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MolliePaymentController extends Controller
{
    public $api_key;
    public $profile_id;
    public $partner_id;
    public $is_enabled;
    public $currancy;

    public function __construct()
    {
        $this->middleware(
            [
                'auth',
                'XSS',
            ]
        );

        $payment_setting  = Utility::getPaymentSetting($_REQUEST['invoice_creator']);
        $invoice          = Invoice::find($_REQUEST['invoice_creator']);
        $this->currancy   = (isset($invoice->project)) ? $invoice->project->currency_code : 'USD';
        $this->api_key    = isset($payment_setting['mollie_api_key']) ? $payment_setting['mollie_api_key'] : '';
        $this->profile_id = isset($payment_setting['mollie_profile_id']) ? $payment_setting['mollie_profile_id'] : '';
        $this->partner_id = isset($payment_setting['mollie_partner_id']) ? $payment_setting['mollie_partner_id'] : '';
        $this->is_enabled = isset($payment_setting['is_mollie_enabled']) ? $payment_setting['is_mollie_enabled'] : 'off';
    }

    public function invoicePayWithMollie(Request $request)
    {
        $validatorArray = [
            'amount' => 'required',
            'invoice_id' => 'required',
        ];
        $validator      = Validator::make(
            $request->all(), $validatorArray
        )->setAttributeNames(
            ['invoice_id' => 'Invoice']
        );

        if($validator->fails())
        {
            return redirect()->back()->with('error', __($validator->errors()->first()));
        }

        $invoice = Invoice::find($request->invoice_id);
        if($invoice->getDue() < $request->amount)
        {
            return redirect()->route('invoices.show', $invoice->id)->with('error', __('Invalid amount.'));
        }

        $mollie = new \Mollie\Api\MollieApiClient();
        $mollie->setApiKey($this->api_key);

        $payment = $mollie->payments->create(
            [
                "amount" => [
                    "currency" => $this->currancy,
                    "value" => number_format($request->amount, 2),
                ],
                "description" => "payment for invoice",
                "redirectUrl" => route(
                    'invoice.mollie', [
                                        encrypt($invoice->id),
                                        'invoice_creator=' . $request->invoice_creator,
                                    ]
                ),
            ]
        );

        session()->put('mollie_payment_id', $payment->id);

        return redirect($payment->getCheckoutUrl())->with('payment_id', $payment->id);
    }

    public function getInvoicePaymentStatus($invoice_id, Request $request)
    {
        if(!empty($invoice_id))
        {
            $mollie = new \Mollie\Api\MollieApiClient();
            $mollie->setApiKey($this->api_key);

            $invoice_id = decrypt($invoice_id);
            $invoice    = Invoice::find($invoice_id);
            if($invoice && session()->has('mollie_payment_id'))
            {
                try
                {
                    $payment = $mollie->payments->get(session()->get('mollie_payment_id'));

                    if($payment->isPaid())
                    {
                        $invoice_payment                 = new InvoicePayment();
                        $invoice_payment->transaction_id = app('App\Http\Controllers\InvoiceController')->transactionNumber();
                        $invoice_payment->invoice_id     = $invoice->id;
                        $invoice_payment->amount         = isset($payment->amount->value) ? $payment->amount->value : 0;
                        $invoice_payment->date           = date('Y-m-d');
                        $invoice_payment->payment_id     = 0;
                        $invoice_payment->payment_type   = 'Mollie';
                        $invoice_payment->notes          = '';
                        $invoice_payment->client_id      = Auth::user()->id;
                        $invoice_payment->save();

                        if(($invoice->getDue() - $invoice_payment->amount) == 0)
                        {
                            Invoice::change_status($invoice->id, 3);
                        }
                        else
                        {
                            Invoice::change_status($invoice->id, 2);
                        }

                        $settings  = Utility::settings(Auth::user()->id);
                   
                        if(isset($settings['invoice_status_notificaation']) && $settings['invoice_status_notificaation'] == 1){
                            $msg = __('Invoice ').\App\Models\Utility::invoiceNumberFormat($invoice->invoice_id) . ' status changed '. (\App\Models\Invoice::$status[$invoice->status]) ;
                            Utility::send_slack_msg($msg);    
                        }

                         if(isset($settings['telegram_invoice_status_notificaation']) && $settings['telegram_invoice_status_notificaation'] == 1){
                            $resp =__('Invoice ').\App\Models\Utility::invoiceNumberFormat($invoice->invoice_id) . ' status changed '. (\App\Models\Invoice::$status[$invoice->status]) ;
                            Utility::send_telegram_msg($resp);    
                        }


                        return redirect()->route('invoices.show', $invoice_id)->with('success', __('Invoice paid Successfully!'));
                    }
                    else
                    {
                        return redirect()->route('invoices.show', $invoice_id)->with('error', __('Transaction fail'));
                    }
                }
                catch(\Exception $e)
                {
                    return redirect()->route('invoices.show', $invoice_id)->with('error', __('Something went wrong.'));
                }
            }
            else
            {
                return redirect()->route('invoices.show', $invoice_id)->with('error', __('Invoice not found.'));
            }
        }
        else
        {
            return redirect()->route('invoices.index')->with('error', __('Invoice not found.'));
        }
    }
}
