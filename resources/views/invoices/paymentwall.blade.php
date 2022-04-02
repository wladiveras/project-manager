<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
{{-- {{ dd( $admin_payment_setting) }} --}}
@php
 $invoice = $data['amount'];
 $cur = env('CURRENCY');

@endphp

<script src="https://api.paymentwall.com/brick/build/brick-default.1.5.0.min.js"> </script>
<div id="payment-form-container"> </div>
<script>
  var brick = new Brick({
    public_key: '{{ $company_payment_setting['paymentwall_public_key'] }}', // please update it to Brick live key before launch your project
    amount: '{{ $invoice }}',
    currency: 'USD',
    container: 'payment-form-container',
    action: '{{route("invoice.pay.with.paymentwall",[$data["invoice_id"],"amount" => $data["amount"]])}}',
    form: {
      merchant: 'Paymentwall',
      product: 'Gold Membership',
      pay_button: 'Pay',
      show_zip: true, // show zip code 
      show_cardholder: true // show card holder name 
    }
});

brick.showPaymentForm(function(data) {
      if(data.flag == 1){
        console.log('dsfrserf');
        window.location.href ='{{route("error.invoice.show",[1, 'invoice_id'])}}'.replace('invoice_id',data.invoice);
      }else{
        console.log('22222');
        window.location.href ='{{route("error.invoice.show",[2, 'invoice_id'])}}'.replace('invoice_id',data.invoice);
      }
    }, function(errors) {
      if(errors.flag == 1){
        console.log('xcfdr');
        window.location.href ='{{route("error.invoice.show",[1,'invoice_id'])}}'.replace('invoice_id',errors.invoice);
      }else{
        console.log('11111');
        window.location.href ='{{route("error.invoice.show",[2, 'invoice_id'])}}'.replace('invoice_id',errors.invoice);
      }
      	   
    });
  
</script>