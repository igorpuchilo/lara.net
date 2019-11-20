@extends('layouts.app')

@section('content')
    <section class="content container mt-4">
        <h2 class="text-center">Search result:</h2>
        {{ Breadcrumbs::render('Search',$query) }}
        <div class="row align-content-stretch">
            @include('shop.components.product_card')
        </div>
        <div class="container">
            @if ($products->total() > $products->count())
                <br>
                    <div class="col-md-12 d-flex align-items-center justify-content-center">
                        {{$products->links()}}
                    </div>
            @endif
        </div>
    </section>
@endsection