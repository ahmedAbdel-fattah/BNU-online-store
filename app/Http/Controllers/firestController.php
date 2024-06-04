<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class firestController extends Controller
{
    public function mainPage()
    {
        if(Auth::check()){

        $categories = Category::all();

        }
        else{
            $categories = Category::take(3)->get();
        }
        return view('welcome', ['categories' => $categories]);
    }

    public function storeReview(Request $request)
    {

        $request->validate([

            'name' => 'required|max:100',
            'phone' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'message' => 'required'


        ]);

$newReview = new Review();
$newReview ->name = $request->name;
$newReview ->phone = $request->phone;
$newReview ->email = $request->email;
$newReview ->subject = $request->subject;
$newReview ->message = $request->message;
$newReview ->save();

        return redirect('/reviews');
    }

    public function reviews()
    {
        $reviews = Review::all();
        return view('reviews',['reviews'=>$reviews]);
    }

    public function getCategoryProducts($catid = null)
    {
        if ($catid) {
            $products = Product::where('category_id', $catid)->paginate(6);
            return view('product', ['products' => $products]);
        } else {
            $products = Product::paginate(6);
            return view('product', ['products' => $products]);
        }
    }

    public function getAllCategoryWithProducts()
    {
        $categories = Category::all();
        $products = Product::all();
        return view('category', ['products' => $products, 'categories' => $categories]);
    }
}
