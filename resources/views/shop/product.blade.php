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
                                <div class="corner-ribbon top-right sticky red">Hit!</div>
                                {{-- Small image --}}
                                <img src="{{asset("/uploads/gallery/preview_$images[0]")}}"
                                     alt="" class="img-responsive">
                            </a>
                            <div class="product-gallery-items">
                                @foreach($images as $image)
                                    <a data-fancybox="gallery"
                                       href="{{asset("/uploads/gallery/$image")}}">
                                        {{-- Small image --}}
                                        <img src="{{asset("/uploads/gallery/thumb_$image")}}"
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
                    <p class="product-description">{{$product->content}}</p>
                    <h4>Спецификация</h4>
                    <table class="table table-bordered table-hover mb-4">
                        <thead>
                        <tr>
                            <td>Характеристика</td>
                            <td>Значение</td>
                        </tr>
                        </thead>
                        <tbody>
                        @for ($i = 0; $i < $groupfilter->count(); $i++)
                        <tr>
                            <td>{{$group_filter[$i]}}</td>
                            <td>{{$filter[$i]}}</td>
                        </tr>
                        @endfor
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-6">
                            <form action="" class="product-form form-inline">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <button id="productQuanDecrease" class="btn btn-outline-dark" type="button">-
                                        </button>
                                    </div>
                                    <input id="product-quantity" class="form-control" type="text" value="1"/>
                                    <div class="input-group-append">
                                        <button id="productQuanIncrease" class="btn btn-outline-dark" type="button">+
                                        </button>
                                    </div>
                                </div>
                                {{-- On change input value: https://stackoverflow.com/questions/8747439/detecting-value-change-of-inputtype-text-in-jquery --}}
                                <div class="form-group mx-sm-3">
                                    <input type="submit" class="btn btn-outline-dark" value="Add to cart"/>
                                </div>
                            </form>
                        </div>
                        <div class="col-6 text-right">
                            <p class="product-price">
                                {{$product->price}} <span class="currency">{{$curr->symbol_right}}</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection