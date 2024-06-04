@extends('Layouts.master')

@section('content')





    <div class="single-product mt-150 mb-150">
        <div class="container">

            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">{{ __('string.productDetails') }} </span></h3>
                </div>
            </div>


            <div class="row">
                <div class="col-md-5">
                    <div class="single-product-img">
                        <img src="{{ asset($product->imagepath) }}" alt="">
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="single-product-content">
                        <h3>{{ session('locale') == 'ar' ? $product->name : $product->nameEN }}</h3>
                        <p>{{ __('string.category') }} : {{ session('locale') == 'ar' ? $product->Category->name : $product->Category->nameEN }}</p>

                        <p class="single-product-pricing"><span>{{ __('string.quantity') }} :
                                {{ $product->quantity }}</span> {{ __('string.price') }} $ {{ $product->price }}</p>
                        <p>{{ $product->descripyion }}</p>

                        <div class="single-product-form">

                            <a href="/addproducttocart/{{ $product->id }}" class="cart-btn"><i
                                    class="fas fa-shopping-cart"></i>{{ __('string.addToCart') }}</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- testimonail-section -->
    <div class="testimonail-section mt-80 mb-150">
        <div class="container">

            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text">{{ __('string.productsImages') }} </span></h3>
                </div>
            </div>
            <div class="row">

                @if ($product->ProductPhotos->count() > 1)
                    <div class="col-lg-10 offset-lg-1 text-center">
                        <div class="testimonial-sliders">


                            @foreach ($product->ProductPhotos as $item)
                                <div class="single-testimonial-slider">
                                    <div class="client-avater">
                                        <img style="width: 20%; height: 300px; max-width:none !important; border:black 5px; border-radius:5px 100px !important"
                                            src="{{ asset($item->imagepath) }}" alt="">
                                    </div>
                                    <div class="client-meta">

                                        <div class="last-icon">
                                            <i class="fas fa-quote-right"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
   <!-- product section -->
   <div class="product-section mt-100 mb-150">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 offset-lg-2 text-center">
                <div class="section-title">
                    <h3><span class="orange-text"> {{ __('string.similarProducts') }} </span></h3>
                </div>
            </div>
        </div>

        <div class="row">


            @foreach ($relatedProducts as $item)
                <div class="col-lg-4 col-md-6 text-center">
                    <div class="single-product-item">
                        <div class="product-image">
                            <a href="/single-product/{{ $item->id }}">
                                <img style="max-height: 250px !important ; min-height: 250px !important"
                                    src="{{ asset($item->imagepath) }}" alt=""></a>
                        </div>
                        <h3>{{ session('locale') == 'ar' ? $item->name : $item->nameEN }}</h3>
                        <p class="product-price"><span>{{ __('string.quantity') }} : {{ $item->quantity }}</span>
                            {{ $item->price }} $</p>

                        <a href="/addproducttocart/{{ $item->id }}" class="cart-btn">
                            <i class="fas fa-shopping-cart"></i>{{ __('string.addToCart') }} </a>


                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>




@endsection
