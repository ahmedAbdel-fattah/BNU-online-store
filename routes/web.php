<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\firestController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CartController;
use App\Models\Cart;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [firestController::class, 'mainPage'])->middleware('customauth');

Route::get('/products/{catid?}', [firestController::class, 'getCategoryProducts'])->name('prods');;

Route::get('category', [firestController::class, 'getAllCategoryWithProducts'])->name('cats');

Route::get('/addproduct', [ProductController::class, 'AddProduct'])->middleware('checkrole:admin');

Route::get('/reviews', [firestController::class, 'reviews']);

Route::post('/storeReview', [firestController::class, 'storeReview']);


Route::get('/editproduct/{productid?}', [ProductController::class, 'EditProducts'])->middleware('checkrole:admin');

Route::get('/removeproduct/{productid?}', [ProductController::class, 'RemoveProducts'])->middleware('checkrole:admin');

Route::post('/storeproduct', [ProductController::class, 'StorProduct']);

Route::post('/search', function (Request $request) {
    $products = Product::where('name', 'like', '%' . $request->searchkey . '%')->paginate(6);
    return view('product', ['products' => $products]);
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/ProductsTable', [ProductController::class, 'ProductsTable'])->name('ProductsTable')->middleware('checkrole:admin');

Route::get('/single-product/{productid}', [ProductController::class, 'showProduct'])->name('single-product');


Route::get('/AddProductImages/{productid}', [ProductController::class, 'AddProductImages'])->middleware('checkrole:admin');

Route::get('/removeproductphoto/{imageid?}', [ProductController::class, 'removeproductphoto'])->middleware('checkrole:admin');
Route::post('/storeProductImage', [ProductController::class, 'storeProductImage'])->middleware('checkrole:admin');
Route::post('/storeOrder', [CartController::class, 'storeOrder']);



Route::get('/cart', [CartController::class, 'cart'])->middleware('auth');

Route::get('/Completeorder', [CartController::class, 'Completeorder'])->middleware('auth');
Route::get('/previousorder', [CartController::class, 'previousorder'])->middleware('auth');


Route::get('/deletecartitem/{cartid}', function ($cartid) {
    Cart::find($cartid)->delete();
    return redirect('/cart');
});



Route::get('/addproducttocart/{product_id}', function ($productid) {


    $user_id = auth()->user()->id;

    $result = Cart::where('user_id', $user_id)->where('product_id', $productid)->first();

    if ($result) {
        $result->quantity += 1;
        $result->save();
    } else {


        $newCart = new Cart();
        $newCart->product_id = $productid;
        $newCart->user_id = $user_id;
        $newCart->quantity = 1;
        $newCart->save();
    }
    return redirect('/cart');
})->middleware('auth');




Route::post('/lang', function (Request $request) {
    session()->put('locale', $request->locale);
    return redirect()->back();
})->name('changeLanguage');


Route::get('/admin/login', function(){
return "Admin login";
});

Route::get('/admin/index', function(){
    return "Admin Panel";
    })->middleware('checkrole:admin');


Route::get('/admin/chart', function(){
    return "Admin charts";
    })->middleware('checkrole:admin,salesman');




Route::get('/admin/bills', function(){
    return "Admin bills";
    })->middleware('checkrole:salesman');
