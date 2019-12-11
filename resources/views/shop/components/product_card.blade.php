@if(isset($products)&&isset($curr))
    @foreach($products as $product)
        @if(isset($groupsfilter))
            <div class="col-lg-4 col-md-4 col-sm-6 mb-4">
                @else
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                        @endif
                        <div class="card h-100">
                            <a class="text-center product-link" href="{{route('shop.getproduct', $product->alias)}}">
                                @if(!empty($product->img))
                                    <img class="card-img-top" style="height: 180px;width: 150px;"
                                         src="{{asset('storage/uploads/single/'.$product->img)}}"
                                         alt="Image not found"
                                         onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
                                @else
                                    <img class="card-img-top"
                                         src="{{asset('storage/images/no_image.jpg')}}" alt="Image not found">
                                @endif
                                @if ($product->hit ==1)
                                    <div class="corner-ribbon top-right sticky red small">Hit!</div>
                                @endif
                            </a>
                            <div class="card-body p-1 text-center">
                                <a href="{{route('shop.getproduct', $product->alias)}}"
                                   class="nav-link text-secondary">{{$product->title}}
                                </a>
                            </div>
                            <div class="card-footer">
                                <form action="{{route('shop.user.addOrder')}}" method="POST">
                                    @csrf
                                    <span class="w-100" style="vertical-align: sub;" id="price">Price:
                                        @if (isset($product->old_price))
                                            <del class="old-price">{{$product->old_price}}</del>&nbsp;
                                        @endif
                                        <span class="value @if (isset($product->old_price)) value-sale @endif">
                                            {{$product->price}}
                                        </span>
                                        <span class="currency">
                                            {{$curr->symbol_right}}
                                        </span>
                                    </span>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-dark btn-sm btn-number" id="minus-btn"
                                                    disabled="disabled" data-type="minus"
                                                    data-field="quant[{{$product->id}}]">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text" id="qty_input" name="quant[{{$product->id}}]"
                                               class="form-control form-control-sm text-center input-number"
                                               value="1" min="1" max="100">
                                        <div class="input-group-prepend">
                                            <button class="btn btn-dark btn-sm btn-number" id="plus-btn"
                                                    data-type="plus" data-field="quant[{{$product->id}}]">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <b>Total:
                                                <span class="text-right"
                                                      id="quant[{{$product->id}}]">{{$product->price}}</span>
                                                <span class="currency">{{$curr->symbol_right}}</span>
                                            </b>
                                            <input id="quant[{{$product->id}}]" value="{{$product->price}}" hidden>
                                            @if (Auth::check())
                                                <button type="submit" class="btn links" style="float: right;">
                                                    <i class="fa fa-shopping-cart fa-lg"></i>
                                                </button>
                                            @else
                                                <a href="{{route('register')}}" class="btn links"
                                                   style="float: right">
                                                    <i class="fa fa-shopping-cart fa-lg"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    <input name="price" id="price" value="{{$product->price}}" hidden>
                                    <input name="product_title" value="{{$product->title}}" hidden>
                                    <input name="product_id" value="{{$product->id}}" hidden>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->
            @endforeach
        @endif