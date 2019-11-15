@if(isset($products)&&isset($curr))
    @foreach($products as $product)
        @if(isset($groupfilter))
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                @else
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        @endif
                        <div class="card h-100">
                            <a class="text-center product-link" href="{{route('shop.getproduct', $product->id)}}">
                                @if(!empty($product->img))
                                    <img class="card-img-top" style="height: 200px;width: 125px;"
                                         src="{{asset('uploads/single/'.$product->img)}}"
                                         alt="">
                                @else
                                    <img class="card-img-top"
                                         src="{{asset('images/no_image.jpg')}}" alt="image">
                                @endif
                                @if ($product->hit ==1)
                                    <div class="corner-ribbon top-right sticky red small">Hit!</div>
                                @endif
                            </a>
                            <div class="card-body p-1 text-center">
                                <a href="{{route('shop.getproduct', $product->id)}}"
                                   class="nav-link text-secondary">{{$product->title}}
                                </a>
                            </div>
                            <div class="card-footer">
                    <span class="w-100" style="vertical-align: sub;">Price:
                        @if (isset($product->old_price))
                            <del class="old-price">{{$product->old_price}}</del>&nbsp;
                        @endif
                        <span class="value @if (isset($product->old_price)) value-sale @endif">{{$product->price}}</span>
                        <span class="currency">{{$curr->symbol_right}}</span>
                        <a class="btn btn-outline" href="{{{url('/cart')}}}"
                           style="float: right;">
                            <i class="fa fa-shopping-cart fa-lg"></i>
                        </a>
                    </span>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
            @endforeach
        @endif