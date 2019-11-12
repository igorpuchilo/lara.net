@extends('layouts.app')

@section('content')
    <form id="cart" class="cart" action="{{url('/cart/save', $order->id)}}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="container">
                    <div class="row">
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
                                                            class="fa fa-fw fa-close text-danger"></i>
                                                </a>{{$prod->title}}</td>
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
                                          placeholder="Additional information: telephone, email, person who will
                                          recieve product(s)" rows="4" style="resize: none;">{{$order->note}}</textarea>
                            </div>
                            <div class="form-group">
                                <button id="cartSubmitButton" class="btn btn-dark" type="submit">Submit order
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection