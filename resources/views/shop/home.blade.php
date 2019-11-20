@extends('layouts.app')

@section('content')
    <header>
        <div class="container">
            <h1>Laravel Shop</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid architecto cum cumque dolor error,
                eveniet facilis fugit iusto magnam nam officiis quaerat recusandae veniam. Dignissimos ipsa iusto nulla
                quisquam tenetur?</p>
        </div>
    </header>
    <section class="content container mt-4">
        {{ Breadcrumbs::render('Home') }}
        <h2 class="text-center">Recently added</h2>
        <div class="row align-content-stretch">
            @include('shop.components.product_card')
        <!-- /.row -->
        </div>
        <!-- /.col-lg-9 -->
    </section>
@endsection
