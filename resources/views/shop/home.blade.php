@extends('layouts.app')

@section('content')
    <header>
        <div class="container">
            <h1>{!! \App\Shop\Core\ShopApp::get_Instance()->getProperty('store_name') !!}</h1>
            <p>{!! \App\Shop\Core\ShopApp::get_Instance()->getProperty('store_description') !!}</p>
        </div>
    </header>
    <section class="content container mt-4">
        <h2 class="text-center">Recently added</h2>
        <div class="row align-content-stretch">
            @include('shop.components.product_card')
        <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
    </section>
@endsection
