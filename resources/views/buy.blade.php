@extends('layouts.app')
    
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    You will be charged
                </div>
  
                <div class="card-body">
  
                    <form id="payment-form" action="{{ route('subscription.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="plan" id="plan" value="">
  
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Name</label>
                                    <input type="text" name="name" id="card-holder-name" class="form-control" value="" placeholder="Name on the card">
                                </div>
                            </div>
                        </div>
  
                        <div class="row">
                            <div class="col-xl-4 col-lg-4">
                                <div class="form-group">
                                    <label for="">Card details</label>
                                    <div id="card-element"></div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                            <hr>
                            <button class="btn btn-primary btn-block" id="checkout-button"><i class="fa fa-cc-stripe"></i> Pay {{ number_format(400, 2) }}</button>
                            </div>
                        </div>
  
                    </form>
  
                </div>
            </div>
        </div>
    </div>
</div>
  
<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var checkoutButton = document.getElementById("checkout-button");
    checkoutButton.addEventListener("click", function () {
        fetch("{{ route('checkout') }}", {
            method: "POST",
        })
        .then(function (response) {
            return response.json();
        })
        .then(function (session) {
            return stripe.redirectToCheckout({ sessionId: session.id });
        })
        .then(function (result) {
            if (result.error) {
                alert(result.error.message);
            }
        })
        .catch(function (error) {
            console.error("Error:", error);
        });
    });
</script>

@endsection