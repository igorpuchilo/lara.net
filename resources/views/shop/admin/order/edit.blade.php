@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        <h1>
            Edit
            Order # {{$item->id}}

            @if (!$order->status)
                <a href="{{route('shop.admin.orders.change', $item->id)}}/?status=1" class="btn btn-success btn-xs">Complete</a>
                <a href="" class="btn btn-warning btn-xs editorder">Edit</a>
            @else
                <a href="{{route('shop.admin.orders.change', $item->id)}}/?status=0" class="btn btn-default btn-xs">Back to rework</a>
            @endif

            <a class="btn btn-xs" href="">
                <form id="delfrom" method="POST" action="{{route('shop.admin.orders.destroy',$item->id)}}" style="float : none">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger btn-xs delete">Delete</button>
                </form>
            </a>
        </h1>
        @component('shop.admin.components.breadcrumb')
            @slot('parent') Home @endslot
            @slot('order') Orders List @endslot
            @slot('active') Order #{{$item->id}} @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <form action="{{route('shop.admin.orders.save', $item->id)}}" method="POST">
                                @csrf
                                <table class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <td>Order Num</td>
                                        <td>{{$order->id}}</td>
                                    </tr>
                                    <tr>
                                        <td>Order Date</td>
                                        <td>{{$order->created_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Update</td>
                                        <td>{{$order->updated_at}}</td>
                                    </tr>
                                    <tr>
                                        <td>Number of products in order</td>
                                        <td>{{count($order_prod)}}</td>
                                    </tr>
                                    <tr>
                                        <td>Summary</td>
                                        <td>{{$order->sum}} {{$order->currency}}</td>
                                    </tr>
                                    <tr>
                                        <td>User name</td>
                                        <td>{{$order->name}}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>{{$order->status ? 'Complete' : 'New'}}</td>
                                    </tr>
                                    <tr>
                                        <td>Note</td>
                                        <td><input type="text" value="@if (isset($order->note)) {{$order->note}}" @endif
                                                   placeholder="@if (!isset($order->note)) No Comment @endif "
                                                   name="comment"></td>
                                    </tr>
                                    </tbody>
                                </table>
                                <input type="submit" name="submit" class="btn btn-warning" value="Save">
                            </form>
                        </div>
                    </div>
                </div>

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