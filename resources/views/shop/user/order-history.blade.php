@extends('layouts.app')

@section('content')

    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="container mt-5">
                {{ Breadcrumbs::render('Order') }}
                <div class="row justify-content-center">
                    <h3>Orders History</h3>
                    @php $i=0;@endphp
                    @if($orders->isNotEmpty())
                        @foreach($orders as $order)
                                <div class="col-lg-12">
                                    <h4>Order Number #{{$order->id}} At {{$order->updated_at}}</h4>
                                    @if (isset($order_prods))
                                        <table class="table table-bordered table-hover">
                                            <thead class="thead-dark">
                                            <tr>
                                                <th>Product</th>
                                                <th>Count</th>
                                                <th>Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php $qty = 0 ?>
                                            @foreach($order_prods[$i] as $prod)
                                                <tr>
                                                    <td><a class="links"
                                                           href="{{route('shop.getproduct', $prod->alias)}}">
                                                            {{$prod->prod_title}}</a>
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
                                            <tr class="active">
                                                <td><b>Note:</b></td>
                                                <td colspan="2"><b>{{$order->note}}</b></td>
                                            </tr>
                                            <tr class="active">
                                                <td><b>Status:</b></td>
                                                <td colspan="2"><b>
                                                        @if ($order->status == 0)
                                                            Waiting Response From Store
                                                        @endif
                                                        @if ($order->status == 1)
                                                            Completed
                                                        @endif
                                                    </b></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    @else
                                        <h2 class="text-center">
                                            <i class="fa fa-fw fa-warning"></i>
                                            Your Cart Is Empty
                                            <br>
                                            <br>
                                            <a href="{{url('/home')}}" class="btn btn-linkedin text-info"><h4>Go To
                                                    Store<i
                                                            class="fa fa-fw fa-shopping-cart"></i></h4></a>
                                        </h2>
                                    @endif
                                    <hr>
                                </div>
                            @php $i++; @endphp
                        @endforeach
                    @else
                        <div class="col-lg-12 text-center">
                            <img src="{{asset("storage/images/empty_history.jpg")}}" alt="History is Empty" height="260px" width="270px">
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