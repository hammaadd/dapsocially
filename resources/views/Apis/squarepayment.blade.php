@extends('user.layout.userlayout')
@section('title','Check Out')

@section('content')
<br><br><br><br>
<div id="form-container">
  <div id="sq-ccbox">
    <!--
      Be sure to replace the action attribute of the form with the path of
      the Transaction API charge endpoint URL you want to POST the nonce to
      (for example, "/process-card")
    -->
    <form id="nonce-form" novalidate action="{{route('payment.process')}}" method="post">
      <fieldset>
        <span class="label">Card Number</span>
        <div id="sq-card-number"></div>

        <div class="third">
          <span class="label">Expiration</span>
          <div id="sq-expiration-date"></div>
        </div>

        <div class="third">
          <span class="label">CVV</span>
          <div id="sq-cvv"></div>
        </div>

        <div class="third">
          <span class="label">Postal</span>
          <div id="sq-postal-code"></div>
        </div>
      </fieldset>

      <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Pay $1.00</button>

      <div id="error"></div>

      <!--
        After a nonce is generated it will be assigned to this hidden input field.
      -->
	  <input type="hidden" id="amount" name="amount" value="100">
      <input type="hidden" id="card-nonce" name="nonce">
    </form>
  </div> <!-- end #sq-ccbox -->

</div>

{{-- <form id="payment-form">
    <div id="card-container"></div><br><br><br><br>
    <button id="card-button" type="button">Pay $1.00</button>
  </form>
  <div id="payment-status-container"></div> --}}


 @endsection

  @section('extrascripts')
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- link to the SqPaymentForm library -->
  <script type="text/javascript" src="https://js.squareup.com/v2/paymentform">
  </script>

  <!-- link to the local SqPaymentForm initialization -->
  <script type="text/javascript" src="{{asset('payment/js/sqpaymentform.js')}}">
  </script>

  <!-- link to the custom styles for SqPaymentForm -->
  <link rel="stylesheet" type="text/css" href="{{asset('payment/css/sqpaymentform-basic.css')}}">
<script>
 document.addEventListener("DOMContentLoaded", function(event) {
   
  if (SqPaymentForm.isSupportedBrowser()) {
    paymentForm.build();
    
  }
});
</script>


{{-- <script>
    const  appId = 'sandbox-sq0idb-R9LmKFQSWNTm_aA4ZD04sw';
    const locationId = 'LVTKK4KR6AXZ9'; 
    async function initializeCard(payments) {
       const card = await payments.card();
       await card.attach('#card-container'); 
       return card; 
     }
      // Call this function to send a payment token, buyer name, and other details
 // to the project server code so that a payment can be created with 
 // Payments API
 async function createPayment(token) {
   const body = JSON.stringify({
     locationId,
     sourceId: token,

   });
   const paymentResponse = await fetch('/payment', {
     method: 'POST',
     headers: {
       'Content-Type': 'application/json',
     },
     body,
   });
   if (paymentResponse.ok) {
     return paymentResponse.json();
   }
   const errorBody = await paymentResponse.text();
   throw new Error(errorBody);
 }

 // This function tokenizes a payment method. 
 // The ‘error’ thrown from this async function denotes a failed tokenization,
 // which is due to buyer error (such as an expired card). It is up to the
 // developer to handle the error and provide the buyer the chance to fix
 // their mistakes.
 async function tokenize(paymentMethod) {
   const tokenResult = await paymentMethod.tokenize();
   if (tokenResult.status === 'OK') {
     return tokenResult.token;
   } else {
     let errorMessage = `Tokenization failed-status: ${tokenResult.status}`;
     if (tokenResult.errors) {
       errorMessage += ` and errors: ${JSON.stringify(
         tokenResult.errors
       )}`;
     }
     throw new Error(errorMessage);
   }
 }
 
 // Helper method for displaying the Payment Status on the screen.
 // status is either SUCCESS or FAILURE;
 function displayPaymentResults(status) {
   const statusContainer = document.getElementById(
     'payment-status-container'
   );
   if (status === 'SUCCESS') {
     statusContainer.classList.remove('is-failure');
     statusContainer.classList.add('is-success');
   } else {
     statusContainer.classList.remove('is-success');
     statusContainer.classList.add('is-failure');
   }

   statusContainer.style.visibility = 'visible';
 }    

     
     
    
    document.addEventListener('DOMContentLoaded', async function () {
      if (!window.Square) {
        throw new Error('Square.js failed to load properly');
      }
      const payments = window.Square.payments(appId, locationId);
      let card;
      try {
        card = await initializeCard(payments);
      } catch (e) {
        console.error('Initializing Card failed', e);
        return;
      }
    
      // Step 5.2: create card payment
      async function handlePaymentMethodSubmission(event, paymentMethod) {
   event.preventDefault();

   try {
     // disable the submit button as we await tokenization and make a
     // payment request.
     cardButton.disabled = true;
     const token = await tokenize(paymentMethod);
     const paymentResults = await createPayment(token);
     displayPaymentResults('SUCCESS');

     console.debug('Payment Success', paymentResults);
   } catch (e) {
     cardButton.disabled = false;
     displayPaymentResults('FAILURE');
     console.error(e.message);
   }
 }

 const cardButton = document.getElementById(
   'card-button'
 );
 cardButton.addEventListener('click', async function (event) {
   await handlePaymentMethodSubmission(event, card);
 });

    });
     
        </script> --}}
        
@endsection