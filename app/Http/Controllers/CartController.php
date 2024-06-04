<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\orderdetails;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CartController extends Controller
{
    public function cart()
    {

        $user_id = auth()->user()->id;

        $cartProducts = Cart::with('Product')->where('user_id', $user_id)->get();

        return view('Products.cart', ['cartProducts' => $cartProducts]);
    }





    public function previousorder()
    {
        $user_id=auth()->user()->id;
        $result=Order::with('orderdetails')->where('user_id',$user_id)->get();

        return view('Products.previousorder',['orders'=>$result]);
    }


    public function Completeorder()
    {

        $user_id = auth()->user()->id;

        $cartProducts = Cart::with('Product')->where('user_id', $user_id)->get();

        return view('Products.Completeorder', ['cartProducts' => $cartProducts]);
    }




    public function storeOrder(Request $request)
{
    // Validate the request data
    $request->validate([
        'name' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'note' => 'nullable|string|max:500',
    ]);

    $user_id = auth()->user()->id;

    DB::transaction(function () use ($request, $user_id) {
        // Create and save the order
        $newOrder = new Order();
        $newOrder->name = $request->name;
        $newOrder->address = $request->address;
        $newOrder->email = $request->email;
        $newOrder->phone = $request->phone;
        $newOrder->note = $request->note;
        $newOrder->user_id = $user_id;
        $newOrder->save();

        // Retrieve cart products
        $cartProducts = Cart::with('Product')->where('user_id', $user_id)->get();

        // Save order details
        foreach ($cartProducts as $item) {
            $newOrderDetail = new orderdetails();  // Correct class name to OrderDetail
            $newOrderDetail->product_id = $item->product_id;
            $newOrderDetail->price = $item->Product->price;
            $newOrderDetail->quantity = $item->quantity;
            $newOrderDetail->order_id = $newOrder->id;
            $newOrderDetail->save();
        }

        // Clear the cart
        Cart::where('user_id', $user_id)->delete();
    });

    return redirect('/');
}
}
