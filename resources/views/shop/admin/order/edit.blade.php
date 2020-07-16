@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        <h1>
            Edit
            Order # {{$order->id}}

            @if (!$order->status)
                <a href="{{route('shop.admin.orders.change', $order->id)}}/?status=1" class="btn btn-success btn-xs"
                   title="Complete This Order">Complete</a>
            @elseif($order->status !=3)
                <a href="{{route('shop.admin.orders.change', $order->id)}}/?status=0" class="btn btn-default btn-xs"
                   title="Restore This Order">Back to rework</a>
            @endif
            @if($order->status !=3)
                <a class="btn btn-xs" href="">
                    <form id="updform" method="POST" action="{{route('shop.admin.orders.updatestatus',$order->id)}}"
                          style="float : none">
                        @csrf
                        <button type="submit" class="btn btn-warning btn-xs" title="Back This order To User Cart">
                            Restore to User Cart
                        </button>
                        <input name="order_id" value="{{$order->id}}" hidden>
                    </form>
                </a>
            @endif
            @if($order->status != 2)
                <a class="btn btn-xs" href="">
                    <form id="delfrom" method="POST" action="{{route('shop.admin.orders.destroy',$order->id)}}"
                          style="float : none">
                        @method('DELETE')
                        @csrf
                        <button type="submit" class="btn btn-danger btn-xs delete" title="Delete This Order Safely">
                            Delete
                        </button>
                    </form>
                </a>
            @endif
        </h1>
        @component('shop.admin.components.breadcrumb')
            @slot('parent') Home @endslot
            @slot('order') Orders List @endslot
            @slot('active') Order #{{$order->id}} @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <form action="{{route('shop.admin.orders.save', $order->id)}}" method="POST">
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
                                        <td>@if ($order->status == 0)
                                                New!
                                            @endif
                                            @if ($order->status == 1)
                                                Completed
                                            @endif
                                            @if ($order->status == 2)
                                                Deleted
                                            @endif
                                            @if ($order->status == 3)
                                                On Order Preparation
                                            @endif</td>
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
                        <div class="resp-qnt table-responsive">
                            @if(!$order_prod->isEmpty())
                                <table class="table table-bordered table-hover" id="table">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Count</th>
                                        <th>Price</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $qty = 0 ?>
                                    @foreach($order_prod as $prod)
                                        <tr>
                                            <td>{{$prod->id}}</td>
                                            <td><a class="delete"
                                                   href="{{route('shop.admin.orders.delProd',$prod->id)}}"
                                                   title="Delete This Product"><i
                                                            class="fa fa-fw fa-close text-danger"></i></a>{{$prod->title}}
                                            </td>
                                            <td>
                                                <button class="btn links btn-number" id="minus-btn"
                                                        @if($prod->qty == 1)disabled="disabled" @endif data-type="minus"
                                                        data-field="quant[{{$prod->id}}]">
                                                    <i class="fa fa-minus"></i>
                                                </button>
                                                <input type="text" id="qty_input" name="quant[{{$prod->id}}]"
                                                       class="input-number"
                                                       value="{{$prod->qty , $qty+=$prod->qty}}" min="1" max="100">

                                                <button class="btn links btn-number" id="plus-btn" data-type="plus"
                                                        data-field="quant[{{$prod->id}}]">
                                                    <i class="fa fa-plus"></i>
                                                </button>
                                                <input id="order_id" value="{{$order->id}}" hidden>
                                                <input id="prod_quant[{{$prod->id}}]" value="{{$prod->id}}" hidden>
                                            </td>
                                            <td>{{$prod->price}}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="active">
                                        <td colspan="2"><b>Total:</b></td>
                                        <td><b>{{$qty}}</b></td>
                                        <td><b>{{$order->sum}} {{$order->currency}}</b></td>
                                    </tr>
                                    </tbody>
                                    <div class="box-body" id="image" style="text-align: center;position: relative;">
                                        <img width="50%" height="50%" id="preview_image"/>
                                        <i id="loading" class="fa fa-spinner fa-spin fa-3x fa-fw"
                                           style="position: absolute;left: 40%;top: 40%;display: none"></i>
                                    </div>
                                </table>
                            @else
                                <br><span class="warning text-center"><i
                                            class="fa fa-fw fa-warning"></i>No Data To View!</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection