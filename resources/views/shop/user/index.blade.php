@extends('layouts.app')

@section('content')
    <section class="content m-5">
        <div class="row">
            <div class="col-md-12">
                <h3>Order Details</h3>
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Product</th>
                                    <th>Count</th>
                                    <th>Price</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $qty=0 ?>
                                @foreach($order_prod as $prod)
                                    <tr>
                                        <td>{{$prod->id}}</td>
                                        <td>{{$prod->title}}</td>
                                        <td>{{$prod->qty , $qty+=$prod->qty}}</td>
                                        <td>{{$prod->price}}</td>
                                    </tr>
                                @endforeach
                                <tr class="active">
                                    <td colspan="2"><b>Total:</b></td>
                                    <td><b>{{$qty}}</b></td>
                                    <td><b>{{$order->sum}} {{$order->currency}}</b></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection