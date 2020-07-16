@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Orders @endslot
            @slot('parent') Home @endslot
            @slot('active') Orders List @endslot
        @endcomponent
    </section>

    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            @if(!$orders->isEmpty())
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@sortablelink('id')</th>
                                        <th>@sortablelink('name','Buyer')</th>
                                        <th>@sortablelink('status')</th>
                                        <th>@sortablelink('sum','Summary')</th>
                                        <th>@sortablelink('created_at')</th>
                                        <th>@sortablelink('updated_at')</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($orders as $order)
                                        <?php
                                        switch ($order->status) {
                                            case 0:
                                                $class = 'primary';
                                                break;
                                            case 1:
                                                $class = 'success';
                                                break;
                                            case 2:
                                                $class = 'danger';
                                                break;
                                            case 3:
                                                $class = 'warning';
                                                break;
                                        }
                                        ?>
                                        <tr class="{{$class}}">
                                            <td>{{$order->id}}</td>
                                            <td>{{$order->name}}</td>
                                            <td>
                                                @if ($order->status == 0)
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
                                                @endif
                                            </td>
                                            <td>{{$order->sum}} {{$order->currency}}</td>
                                            <td>{{$order->created_at}}</td>
                                            <td>{{$order->updated_at}}</td>
                                            <td>
                                                <a href="{{route('shop.admin.orders.edit',$order->id)}}" title="Edit">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </a>
                                                @if($order->status == 2)
                                                    <a href="{{route('shop.admin.orders.restore',$order->id)}}"
                                                       title="Restore">
                                                        <i class="fa fa-fw fa-refresh"></i>
                                                    </a>
                                                @endif
                                                <a href="{{route('shop.admin.orders.forcedelete',$order->id)}}"
                                                   title="Delete From DB">
                                                    <i class="fa fa-fw fa-close text-danger deletedb"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td class="text-center" colspan="3"><h2>No Orders</h2></td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>
                            @else
                                <br><span class="warning text-center"><i
                                            class="fa fa-fw fa-warning"></i>No Data To View!</span>
                            @endif
                        </div>
                        <div class="text-center">
                            {!! $orders->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection