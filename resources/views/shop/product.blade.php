@extends('layouts.app')

@section('content')

    <div class="product">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="product-gallery">
                        @if(!empty($images))
                            {{-- Big image --}}
                            <a class="product-link" data-fancybox="gallery"
                               href="{{asset("/uploads/gallery/$images[0]")}}">
                                @if($currentProduct->hit ==1)
                                    <div class="corner-ribbon top-right sticky red">Hit!</div>
                                @endif
                                {{-- Small image --}}
                                <img src="{{asset("/uploads/gallery/preview-$images[0]")}}"
                                     alt="" class="img-responsive">
                            </a>
                            <div class="product-gallery-items">
                                @foreach($images as $image)
                                    <a data-fancybox="gallery"
                                       href="{{asset("/uploads/gallery/$image")}}">
                                        {{-- Small image --}}
                                        <img src="{{asset("/uploads/gallery/thumb-$image")}}"
                                             alt="">
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-md-7">
                    <h1>{{$currentProduct->title}}</h1>
                    {{-- Product desc--}}
                    {!! $currentProduct->content !!}
                    <h4>Спецификация</h4>
                    <table class="table table-bordered table-hover mb-4">
                        <thead>
                        <tr>
                            <td>Attribute</td>
                            <td>Value</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($filters as $filter)
                            <tr>
                                <td>
                                    {{$filter->title}}
                                </td>
                                <td>
                                    {{$filter->value}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-lg-8 col-md-12 col-sm-12">
                            <form action="{{route('shop.user.addOrder', $currentProduct->id)}}" method="POST"
                                  class="product-form form-inline">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button id="productQuanDecrease" class="btn btn-outline-dark" type="button">-
                                        </button>
                                    </div>
                                    <input id="productQuantity" class="form-control" name="productQuantity" type="text"
                                           value="1"/>
                                    <div class="input-group-append">
                                        <button id="productQuanIncrease" class="btn btn-outline-dark" type="button">+
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group mx-3">
                                    @if (Auth::check())
                                        <input type="submit" class="btn btn-outline-dark" value="Add to cart"/>
                                    @else
                                        <a href="{{route('register')}}" class="btn btn-outline-dark">Add to cart</a>
                                    @endif
                                </div>
                                <input id="price" name="price" value="{{$currentProduct->price}}" hidden>
                                <input id="product_title" name="product_title" value="{{$currentProduct->title}}" hidden>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <p class="product-price">
                                @if (isset($currentProduct->old_price))
                                    <del class="old-price">{{$currentProduct->old_price}}</del>&nbsp;
                                @endif
                                <span class="value @if (isset($currentProduct->old_price)) value-sale @endif">{{$currentProduct->price}}</span>
                                <span class="currency">{{$curr->symbol_right}}</span>
                            </p>
                        </div>
                    </div>
                    @include('shop.admin.components.result_messages')
                </div>
            </div>
        </div>
    </div>
    <div class="product">
        <div class="container">
            <h2>Related Products</h2>
            <div class="row">
                @include('shop.components.product_card',['products'=>$related])
            </div>
        </div>
    </div>
@endsection