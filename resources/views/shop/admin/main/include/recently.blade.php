<div class="col-md-6">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Recently added products</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                    <i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        </div>
        @if(!$last_products->isEmpty())
            <div class="box-body">
                <ul class="products-list product-list-in-box">
                    @foreach($last_products as $product)
                        <li class="item">
                            <div class="product-img">
                                @if(!empty($product->img))
                                    <img src="{{asset('storage/uploads/single/'.$product->img)}}" alt="Image not found"
                                         onerror="this.src = '{{asset("storage/images/no_image.jpg")}}';">
                                @else
                                    <img src="{{asset('storage/images/no_image.jpg')}}" alt="Image not found">
                                @endif
                            </div>
                            <div class="product-info">
                                <a href="{{route('shop.admin.products.edit', $product->id)}}" class="product-title">
                                    {{$product->title}}
                                    <span class="label label-warning pull-right">{{$product->price}}</span>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        @else
            <br> <span class="warning text-center"><i
                        class="fa fa-fw fa-warning"></i>No Data To View!</span>
        @endif
        <div class="box-footer clearfix">
            <a href="{{route('shop.admin.products.index')}}" class="btn btn-sm btn-info btn-flat pull-left">All
                products</a>
        </div>

    </div>
</div>