@extends('layouts.app')

@section('content')

    <div class="product">
        <div class="container">
            {{ Breadcrumbs::render('Product', $product) }}
            <div class="row">
                <div class="col-md-5">

                    <div class="product-gallery">
                        @if(!empty($images))
                            {{-- Big image --}}
                            <a class="product-link" data-fancybox="gallery"
                               href="{{asset("/uploads/gallery/$images[0]")}}">
                                @if($product->hit ==1)
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
                    <h1>{{$product->title}}</h1>
                    {{-- Product desc--}}
                    {!! $product->content !!}
                    <h4>Order Details</h4>
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
                            <form action="{{route('shop.user.addOrder', $product->id)}}" method="POST"
                                  class="product-form form-inline">
                                @csrf
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-outline-dark btn-number" id="minus-btn"
                                                disabled="disabled" data-type="minus"
                                                data-field="quant[{{$product->id}}]">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" id="qty_input" name="quant[{{$product->id}}]"
                                           class="form-control text-center input-number"
                                           value="1" min="1" max="100">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-dark btn-number" id="plus-btn"
                                                data-type="plus" data-field="quant[{{$product->id}}]">
                                            <i class="fa fa-plus"></i>
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
                                <input id="price" name="price" value="{{$product->price}}" hidden>
                                <input id="quant[{{$product->id}}]" value="{{$product->price}}" hidden>
                                <input id="product_title" name="product_title" value="{{$product->title}}" hidden>
                            </form>
                        </div>
                        <div class="col-lg-4 col-md-12 col-sm-12">
                            <p class="product-price">
                                @if (isset($product->old_price))
                                    <del class="old-price">{{$product->old_price}}</del>&nbsp;
                                @endif
                                <span class="value @if (isset($product->old_price)) value-sale @endif"
                                      id="quant[{{$product->id}}]">{{$product->price}}</span>
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