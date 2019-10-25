@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Search Result: "{{$query}}" @endslot
            @slot('parent') Home @endslot
            @slot('active') Search @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="container">
            <div class="prdt-top">
                <div class="col-md-9 prdt-left">
                    @foreach($products as $product)
                        <div class="col-md-4 product-left p-left">
                            <div class="product-main simpleCart_shelfItem">
                                <a href="{{url("admin/products/$product->id".'/edit')}}" class="mask">
                                    @if (empty($product->img))
                                        <img class="img-responsive zoom-img" src="{{asset('/images/no_image.jpg')}}"
                                             alt=""/>
                                    @else
                                        <img class="img-responsive zoom-img"
                                             src="{{asset("/uploads/single/$product->img")}}"
                                             alt=""/>
                                    @endif
                                </a>
                                <div class="product-bottom">
                                    <a href="{{url("admin/products/$product->id".'/edit')}}" class="mask"><h3>{{$product->title}}</h3></a>
                                    <p>Explore Now</p>
                                    <h4>
                                        <a data-id="{{$product->id}}" class="add-to-cart-link"
                                           href="#"><i></i></a>
                                        <span class="item_price">{{$currency->symbol_left}}
                                            {{$product->price * $currency->value}} {{$currency->symbol_right}}</span>
                                        @if($product->old_price)
                                            <small>
                                                <del>{{$currency->symbol_left}}
                                                    {{$product->old_price * $currency->value}}
                                                    {{$currency->symbol_right}}</del>
                                            </small>
                                        @endif
                                    </h4>
                                </div>
                                <div class="srch srch1">
                                    <span>{{$product->description}}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </section>
@endsection