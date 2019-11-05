@extends('layouts.app')

@section('content')
    <header>
        <div class="container">
            <h1>Laravel Shop</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid architecto cum cumque dolor error, eveniet facilis fugit iusto magnam nam officiis quaerat recusandae veniam. Dignissimos ipsa iusto nulla quisquam tenetur?</p>
        </div>
    </header>
    <section class="content container mt-4">
        <h2 class="text-center">Recently added</h2>
        <div class="row align-content-stretch">
            @foreach($last_products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 mb-4">
                    <div class="card h-100">
                        <a class="text-center product-link" href="{{route('shop.getproduct', $product->id)}}">
                            @if(!empty($product->img))
                                <img class="card-img-top" style="height: 165px;width: 125px;"
                                     src="{{asset('uploads/single/'.$product->img)}}" alt="image">
                            @else
                                <img class="card-img-top"
                                     src="{{asset('images/no_image.png')}}" alt="image">
                            @endif
                             <div class="corner-ribbon top-right sticky red small">Hit!</div>
                        </a>
                        <div class="card-body p-1">

                                <a href="{{route('shop.getproduct', $product->id)}}"
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
