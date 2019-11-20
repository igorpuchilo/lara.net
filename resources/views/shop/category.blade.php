@extends('layouts.app')

@section('content')
    <div class="category">
        <div class="container">
            <div class="row">
                @include('shop.components.category_filters')
                <div class="col-md-9">
                    <h1>{{$category->title}}</h1>
                    {{ Breadcrumbs::render('Category', $category) }}
                    <ul class="filter">
                        <li class="nav-item">
                            <h5 class="font-weight-bold btn">Sort By:</h5>
                        </li>
                        <li class="nav-item">
                            @sortablelink('price','Price',null,['class' => 'btn btn-outline'])
                        </li>
                        <li class="nav-item">
                            @sortablelink('title','Product Name',null,['class' => 'btn btn-outline'])
                        </li>
                        <li class="nav-item">
                            @sortablelink('created_at','Date',null,['class' => 'btn btn-outline'])
                        </li>
                    </ul>
                    <div class="row align-content-stretch">
                        @include('shop.components.product_card')
                    </div>
                </div>
                <div class="container text-center">
                    <br>
                    <div class="col-md-12 d-flex align-items-center justify-content-center">
                        {!! $products->appends($_GET,\Request::except('page'))->render() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

