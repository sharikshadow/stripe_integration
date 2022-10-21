@extends('layouts.app')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Select Product:</div>
 
                <div class="card-body">
 
                    <div class="row">
                        @foreach($products as $product)
                            <div class="col-md-6">
                                <div class="card mb-3">
                                  <div class="card-header"> 
                                       <strong> Price : </strong>{{ $product->price }}
                                  </div>
                                  <div class="card-body">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                                    <button value="{{ $product->price }}" class="btn btn-primary btn-block class stripe"  id="checkout-button{{$product->id}}"><i class="fa fa-cc-stripe"></i> Pay {{ number_format($product->price, 2) }}</button>
  
                                  </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
  
                </div>
            </div>
        </div>
    </div>
</div>
                                    


<script src="https://polyfill.io/v3/polyfill.min.js?version=3.52.1&features=fetch"></script>
<script src="https://js.stripe.com/v3/"></script>

<script type="text/javascript">
    var stripe = Stripe("{{ env('STRIPE_KEY') }}");
    var buttons = document.getElementsByClassName('stripe');

    for (var i=0;i<buttons.length;i++) {
        buttons[i].addEventListener("click", function (event) {
    var price  = event.target.value;


    var myBody = `{"price":${price}}`;
    console.log(myBody);
         fetch("{{ route('checkout') }}", {
            method: "POST",
            body:  myBody,
            headers: {
            'Content-Type': 'application/json',
            // "X-CSRF-Token": csrfToken
        }
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
    }
    
</script>

@endsection