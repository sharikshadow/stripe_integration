<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::get();
  
        return view("Products", compact("products"));
    }  
    public function checkout(Request $request)
    {

        // dd($request->price);
    // $this->lineItems();

        header('Content-Type: application/json');
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $checkout_session = Session::create([
            'payment_method_types[]' => 'card',
            'customer' => 'cus_MejpzsZIM1b0Lj',
            // 'line_items' => [
            //     [
            //         'price' => 'price_1LvONSSAnnCsSRVBdkimmMc7',
            //         'quantity' => 2,
            //       ],    
            // ],
			'line_items' =>[  [
				"price_data" =>  [
				"currency" => "INR",
				"unit_amount" => $request->price * 100,
				"product_data" =>  [
				  "name" => "test"
				]
				],
		  "quantity" => 1
		]],

          
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/products',
            'cancel_url' => 'http://localhost:8000/checkout',
        ]);

        //returns session id
        return response()->json(['id' => $checkout_session->id]);
    }
    private function lineItems()
    {

        $lineItems = [];
            $product['price_data'] = [
                'currency' => 'INR',
                'unit_amount' => 3 * 100,
                'product_data' => [
                    'name' => "test",
                ],
            ];

            $product['quantity'] = 2;
            dd($product);

            $lineItems[] = $product;

        return $lineItems;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function show(Product $Product, Request $request)
    {
        // $intent = auth()->user()->createSetupIntent();
        $products = Product::get();
  
        return view("buy", compact("Product"));
    }
}
