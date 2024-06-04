@extends('Layouts.authentication')

@section('content')
    <!-- product section -->
    <div class="product-section mt-50 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">Edit</span> Products</h3>

                        <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
<div class="m-5">
{!!$Barcode!!}
</div>

                    </div>
                </div>
            </div>

            <div class="row">

                <div class="col-lg-12 mb-5 mb-lg-0">

                    <div id="form_status"></div>
                    <div class="contact-form">
                        <form method="post" enctype="multipart/form-data" action="/storeproduct" style="text-align: right"
                            dir="rtl">
                            @csrf()
                            <p>
                                <input type="hidden" required style="width: 100%" placeholder="الاسم" name="id"
                                    id="id" value="{{ $product->id }}">

                                <input type="text" required style="width: 100%" placeholder="الاسم" name="name"
                                    id="name" value="{{ $product->name }}">
                                <span class="text-danger">

                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </p>
                            <p style="display: flex;">
                                <input type="number" required style="width: 50%" class="ml-4" placeholder="السعر"
                                    name="price" id="price" value="{{ $product->price }}">

                                <span class="text-danger">

                                    @error('price')
                                        {{ $message }}
                                    @enderror
                                </span>

                                <input type="number" required style="width: 50%" placeholder="الكميه" name="quantity"
                                    id="quantity" value="{{ $product->quantity }}">

                                <span class="text-danger">

                                    @error('quantity')
                                        {{ $message }}
                                    @enderror
                                </span>

                            </p>
                            <p>
                                <textarea name="description" required id="description" cols="30" rows="10" placeholder="الوصف">{{ $product->description }}</textarea>

                                <span class="text-danger">

                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </span>

                            </p>

                            <p>

                                <select class="form-control" name="category_id" required id="category_id">
                                    @foreach ($allcategories as $item)
                                        @if ($item->id == $product->category_id)
                                            <option value="{{ $item->id }}" selected>{{ $item->name }}</option>
                                        @else
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endif
                                    @endforeach
                                </select>


                                <span class="text-danger">

                                    @error('category_id')
                                        {{ $message }}
                                    @enderror
                                </span>
                            </p>

                            <p>
                                <input type="file" name="photo" id="photo" class="form-control">


                                <span class="text-danger">

                                    @error('photo')
                                        {{ $message }}
                                    @enderror
                                </span>

                            </p>

                            <p>
                                <img src="{{ asset($product->imagepath) }}" width="200" height="200" />
                            </p>

                            <p><input type="submit" value="حفظ"></p>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end product section -->
@endsection
