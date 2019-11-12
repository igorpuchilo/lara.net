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

@endsection

