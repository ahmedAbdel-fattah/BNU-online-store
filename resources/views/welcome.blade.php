@extends('Layouts.master')

@section('content')
    <!-- product section -->
    <div class="product-section mt-150 mb-150">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 text-center">
                    <div class="section-title">
                        <h3><span class="orange-text">{{ __('string.categories') }}</span></h3>
                    </div>
                </div>
            </div>

            <div class="row">

                @foreach ($categories as $item)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="single-product-item">
                            <div class="product-image">
                                <a href="{{ route('prods', ['catid' => $item->id]) }}">
                                    <img style="max-height: 250px !important ; min-height: 250px !important"
                                        src="{{ $item->imagepath }}"alt=""></a>
                            </div>
                            <h3>{{ session('locale')=='ar'? $item->name : $item->nameEN}}</h3>
                            <p>{{ $item->description }}</p>

                        </div>
                    </div>
                @endforeach


            </div>
        </div>
    </div>
    <!-- end category section -->
@endsection
