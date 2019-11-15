@extends('layouts.app')

@section('content')
    <div class="category">
        <div class="container">
            <div class="row">
                @include('shop.components.category_filters')
                <div class="col-md-9">
                    <h1>{{$category->title}}</h1>
                    <div class="row align-content-stretch">
                        @include('shop.components.product_card')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container text-center">
        @if ($products->total() > $products->count())
            <br>
            <div class="col-md-12 d-flex align-items-center justify-content-center">
                {{$products->appends($_GET)->links()}}
            </div>
        @endif
    </div>
@endsection

