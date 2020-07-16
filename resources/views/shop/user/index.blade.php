@extends('layouts.app')

@section('content')

    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="container mt-5">
                {{ Breadcrumbs::render('Cart') }}
                <div class="row justify-content-center">
                    @if(isset($order))
                        <div class="cart col-lg-12">
                            @csrf
                            <div class="col-lg-12 resp-qnt">
                                <h4>Order Details</h4>
                                @if (!$order_prod->isEmpty())
                                    <table id="table-cart" class="table-cart table table-bordered table-hover">
                                        <thead class="thead-dark">
                                        <tr>
                                            <th>Product</th>
                                            <th>Count</th>
                                            <th>Price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php $qty = 0 ?>
                                        @foreach($order_prod as $prod)
                                            <tr>
                                                <td><a class="delete"
                                                       href="{{route('shop.user.delProd',$prod->id)}}"
                                                       title="Delete This Product"><i
                                                                class="fa fa-fw fa-close text-danger"></i></a>
                                                    <a class="links"
                                                       href="{{route('shop.getproduct', $prod->alias)}}">{{$prod->prod_title}}</a>
                                                </td>
                                                <td>
                                                    <button class="btn links btn-number-cart" id="minus-btn"
                                                            @if($prod->qty == 1)disabled="disabled"
                                                            @endif data-type="minus"
                                                            data-field="quant-cart[{{$prod->id}}]">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <input type="text" id="qty_input-cart"
                                                           name="quant-cart[{{$prod->id}}]"
                                                           class="input-number-cart"
                                                           value="{{$prod->qty , $qty+=$prod->qty}}" min="1" max="100">

                                                    <button class="btn links btn-number-cart" id="plus-btn"
                                                            data-type="plus"
                                                            data-field="quant-cart[{{$prod->id}}]">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                    <input id="order_id" value="{{$order->id}}" hidden>
                                                    <input id="prod_quant-cart[{{$prod->id}}]" value="{{$prod->id}}" hidden>
                                                </td>
                                                <td>{{$prod->price}}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="active">
                                            <td><b>Total:</b></td>
                                            <td><b>{{$qty}}</b></td>
                                            <td><b>{{$order->sum}} {{$order->currency}}</b></td>
                                        </tr>
                                        </tbody>
                                        <div class="box-body" id="image" style="text-align: center;position: relative;">
                                            <img width="50%" height="50%" id="preview_image"/>
                                            <i id="loading-cart" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                               style="position: absolute;left: 40%;top: 40%;display: none"></i>
                                        </div>
                                    </table>
                                @else
                                    <h2 class="text-center">
                                        <i class="fa fa-fw  fa-warning"></i>
                                        Your Cart Is Empty
                                        <br>
                                        <br>
                                        <a href="{{url('/home')}}" class="btn btn-linkedin text-info"><h4>Go To Store<i
                                                        class="fa fa-fw fa-shopping-cart"></i></h4></a>
                                    </h2>
                                @endif
                            </div>
                            <form id="cart" action="{{route('shop.user.store')}}" method="post">
                                @csrf
                                <div class="col-lg-12 mt-3">
                                    <h4>Customer's Details</h4>
                                    <div class="form-group">
                                <textarea class="form-control" type="text" name="comment" id="comment"
                                          placeholder="Additional information: telephone, email, person who will recieve product(s)"
                                          rows="4" style="resize: none;">{{$order->note}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <button id="cartSubmitButton" class="btn btn-dark" type="submit">Submit order
                                        </button>
                                    </div>
                                </div>
                                <input name="order_id" value="{{$order->id}}" hidden>
                            </form>
                        </div>
                    @else
                        <div class="col-lg-12 text-center">
                            <img src="{{asset("storage/images/no_items_found.jpg")}}" alt="Cart is Empty">
                            <br>
                            <a class="btn btn-outline-dark btn-lg mt-3" href="{{url('/home')}}">
                                <i class="fa fa-shopping-cart"></i> Go To Store</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection