<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RazorpayPaymentController extends Controller
{
    //
    public $secret_key;
    public $public_key;
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
        $this->secret_key = isset($payment_setting['razorpay_secret_key']) ? $payment_setting['razorpay_secret_key'] : '';
        $this->public_key = isset($payment_setting['razorpay_public_key']) ? $payment_setting['razorpay_public_key'] : '';
        $this->is_enabled = isset($payment_setting['is_razorpay_enabled']) ? $payment_setting['is_razorpay_enabled'] : 'off';
    }

    public function invoicePayWithRazorpay(Request $request)
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
            return response()->json(
                [
                    'message' => $validator->errors()->first(),
                ], 401
            );
        }
        $invoice = Invoice::find($request->invoice_id);
        if($invoice->getDue() < $request->amount)
        {
            return response()->json(
                [
                    'message' => __('Invalid amount.'),
                ], 401
            );
        }

        $res_data['email']           = Auth::user()->email;
        $res_data['total_price']     = $request->amount;
        $res_data['currency']        = $this->currancy;
        $res_data['flag']            = 1;
        $res_data['invoice_id']      = $invoice->id;
        $res_data['invoice_creator'] = $invoice->invoice_creator;
        $request->session()->put('invoice_data', $res_data);
        $this->pay_amount = $request->amount;

        return $res_data;
    }

    public function getInvoicePaymentStatus($pay_id, $invoice_id, Request $request)
    {
        if(!empty($invoice_id) && !empty($pay_id))
        {
            $invoice_id   = decrypt($invoice_id);
            $invoice      = Invoice::find($invoice_id);
            $invoice_data = $request->session()->get('invoice_data');
            if($invoice && !empty($invoice_data))
            {
                try
                {
                    $ch = curl_init('https://api.razorpay.com/v1/payments/' . $pay_id . '');
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                    curl_setopt($ch, CURLOPT_USERPWD, $this->public_key . ':' . $this->secret_key); // Input your Razorpay Key Id and Secret Id here
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = json_decode(curl_exec($ch));

                    if($response->status == 'authorized')
                    {
                        $invoice_payment                 = new InvoicePayment();
                        $invoice_payment->transaction_id = app('App\Http\Controllers\InvoiceController')->transactionNumber();
                        $invoice_payment->invoice_id     = $invoice->id;
                        $invoice_payment->amount         = isset($invoice_data['total_price']) ? $invoice_data['total_price'] : 0;
                        $invoice_payment->date           = date('Y-m-d');
                        $invoice_payment->payment_id     = 0;
                        $invoice_payment->payment_type   = 'Razorpay';
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

                        $request->session()->forget('invoice_data');

                        return redirect()->route('invoices.show', $invoice_id)->with('success', __('Invoice paid Successfully!'));
                    }
                    else
                    {
                        return redirect()->route('invoices.show', $invoice_id)->with('error', __('Transaction has been failed.'));
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
