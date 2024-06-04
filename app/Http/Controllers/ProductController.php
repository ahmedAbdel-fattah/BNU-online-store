<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPhoto;
use Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Milon\Barcode\DNS1D;

class ProductController extends Controller
{
    public function AddProduct()
    {


        $allcategories = Category::all();
        return view('Products.addproduct', ['allcategories' => $allcategories]);
    }

    public function RemoveProducts($productid = null)
    {
        if ($productid != null) {
            $currentProduct = Product::find($productid);
            $currentProduct->delete();
            return redirect('/category');
        } else {
            abort(403, "pleas enter product id in the route");
        }
    }




    public function removeproductphoto($imageid = null)
    {
        if ($imageid != null) {
            $photo = ProductPhoto::find($imageid);
            $photo->delete();
            return redirect('/ProductsTable');
        } else {
            abort(403, "pleas enter image id in the route");
        }
    }



    public function showProduct($productid)
    {


        $product = Product::with('Category','productPhotos')->find($productid);
$priceRange = $product->price * 0.10;
$minPrice = $product->price - $priceRange;
$maxPrice = $product->price + $priceRange;

$relatedProducts = Product::where('category_id', $product->category_id)
->where('id', '!=', $productid)
//->whereBetween('price', [$minPrice, $maxPrice])
->inRandomOrder()
->limit(3)
->get();


//$relatedProducts = $product::where('category_id',$product->category_id)->where('id','!=',$productid)->whereBetween('price',[$minPrice,$maxPrice])->inRandomOrder()->limit(3)->get();
        return view('Products.showProduct', ['product' => $product,'relatedProducts'=>$relatedProducts]);
    }



    public function ProductsTable()
    {


        $products = Product::all();
        return view('Products.ProductsTable', ['products' => $products]);
    }





    public function AddProductImages($productid)
    {


        $product = Product::find($productid);
        $productImages = ProductPhoto::where('product_id', $productid)->get();

        return view('Products.AddProductImage', ['product' => $product, 'productImages' => $productImages,'productid'=>$productid]);
    }


    public function EditProducts($productid = null)
    {

        if ($productid != null) {
            $currentProduct = Product::find($productid);
            if ($currentProduct == null) {
                abort("403", "Can't find product");
            }
            $allcategories = Category::all();


$qrCode= QrCode::size(200)->generate('www.bnu.com');

$barcode = new DNS1D();

$Barcode= $barcode->getBarcodeHTML('01156668197','C39');

            return view('Products.editproduct', ['product' => $currentProduct, 'allcategories' => $allcategories,'qrCode'=>$qrCode,'Barcode'=>$Barcode]);
        } else {

            return redirect('/addproduct');
        }
    }







    public function storeProductImage(Request $request)
    {

        $request->validate([

            'product_id' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);
$photo=new ProductPhoto();
$photo->product_id=$request->product_id;

if($request->has('photo')){
$path =$request->photo->move(
'upload',
Str::uuid()->toString() .'-' . $request->photo->getClientOriginalName()
);

$photo->imagepath=$path;

}
$photo->save();


            return redirect('/ProductsTable');
        }






    public function StorProduct(Request $request)
    {

        $request->validate([

            'name' => 'required|max:100',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'description' => 'required',
            'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048',

        ]);



        //تعديل المنتج

        if ($request->id) {

            $currentProduct = Product::find($request->id);
            $currentProduct->name = $request->name;
            $currentProduct->price = $request->price;
            $currentProduct->quantity = $request->quantity;
            $currentProduct->description = $request->description;
            $currentProduct->category_id = $request->category_id;

            if ($request->has('photo')) {
                $path = $request->photo->move('uploads', Str::uuid()->toString() . '-' . $request->photo->getClientOriginalName());
                $currentProduct->imagepath = $path;
            }


            $currentProduct->save();
            return redirect('/products');
        }

        //اضافة المنتج
        else {


            $newProduct = new Product();
            $newProduct->name = $request->name;
            $newProduct->price = $request->price;
            $newProduct->quantity = $request->quantity;
            $newProduct->description = $request->description;
            $newProduct->category_id = $request->category_id;

            $path = '';
            if ($request->has('photo')) {
                $path = $request->photo->move('uploads', Str::uuid()->toString() . '-' . $request->photo->getClientOriginalName());
            }
            $newProduct->imagepath = $path;

            $newProduct->save();

            return redirect('/');
        }
    }






}
