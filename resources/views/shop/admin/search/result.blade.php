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
        <div class="row">
            <div class="col-md-12">
                @if(isset($products)&&isset($curr))
                    @foreach($products as $product)
                        <div class="col-lg-3 col-md-4 col-sm-6 product-card">
                            <div class="panel panel-primary">
                                <div class="panel-body text-center">
                                    <a href="{{url("admin/products/$product->id".'/edit')}}">
                                        @if(!empty($product->img))
                                            <img class="text-center product-img" style="height: 165px;width: 125px;"
                                                 src="{{asset('storage/uploads/single/'.$product->img)}}" alt="Image not found"
                                                 onerror="this.src = '{{asset("/images/no_image.jpg")}}';">
                                        @else
                                            <img class="text-center product-img"
                                                 src="{{asset('storage/images/no_image.jpg')}}" alt="Image not found">
                                        @endif
                                    </a>
                                </div>
                                <div class="panel-footer text-center" style="height: 70px; overflow: hidden;">
                                    <a class="link-black" href="{{url("admin/products/$product->id".'/edit')}}">
                                        {{$product->title}}
                                    </a>
                                </div>
                            </div>
                        </div>
                        <!-- /.row -->
                    @endforeach
                @endif
            </div>
        </div>
        <div class="container text-center">
            @if ($products->total() > $products->count())
                <br>
                <div class="col-md-12 d-flex align-items-center justify-content-center">
                    {{$products->links()}}
                </div>
            @endif
        </div>
    </section>
@endsection