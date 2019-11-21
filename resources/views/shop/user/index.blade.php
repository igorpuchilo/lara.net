@extends('layouts.app')

@section('content')


    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="container mt-5">
                {{ Breadcrumbs::render('Cart') }}
                <div class="row justify-content-center">
                    @if(isset($order))
                        <form id="cart" class="cart col-lg-12" action="{{route('shop.user.store')}}" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <h4>Order Details</h4>
                                @if (isset($order_prod))
                                    <table class="table table-bordered table-hover">
                                        <thead>
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
                                                       href="{{route('shop.getproduct', $prod->alias)}}">{{$prod->title}}</a>
                                                </td>
                                                <td>{{$prod->qty , $qty+=$prod->qty}}</td>
                                                <td>{{$prod->price}}</td>
                                            </tr>
                                        @endforeach
                                        <tr class="active">
                                            <td><b>Total:</b></td>
                                            <td><b>{{$qty}}</b></td>
                                            <td><b>{{$order->sum}} {{$order->currency}}</b></td>
                                        </tr>
                                        </tbody>
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
                    @else
                        <div class="col-lg-12 text-center">
                            <img src="{{asset("/images/no_items_found.jpg")}}" alt="Cart is Empty">
                            <br>
                            <a class="btn btn-outline-dark btn-lg mt-3" href="{{url('/home')}}"><i class="fa fa-shopping-cart"></i> Go To Store</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection