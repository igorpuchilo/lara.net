@extends('layouts.app')

@section('content')
    <section class="content m-4">
        <h2 class="text-left text-monospace">Recently added:</h2>
        <div class="row align-content-stretch">
            @foreach($last_products as $product)
                <div class="m-2">
                    <div class="card h-100 "  style="width: 200px">
                        <a class="text-center" href="{{route('shop.admin.products.edit', $product->id)}}">
                            @if(!empty($product->img))
                                <img class="card-img-top" style="height: 165px;width: 125px;"
                                     src="{{asset('uploads/single/'.$product->img)}}" alt="image">
                            @else
                                <img class="card-img-top"
                                     src="{{asset('images/no_image.png')}}" alt="image">
                            @endif</a>
                        <div class="card-body p-1">

                                <a href="{{route('shop.admin.products.edit', $product->id)}}"
                                   class="btn btn-linkedin">{{$product->title}}
                                </a>
                        </div>
                        <div class="card-footer">
                            <span class="w-100" style="vertical-align: sub;">Price: {{$product->price}}
                                <a class="btn btn-outline" href="{{route('shop.user.cart.index')}}"
                                        style="float: right;">
                                    <i class="fa fa-shopping-cart fa-lg"></i>
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
        @endforeach
        <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
    </section>
@endsection
