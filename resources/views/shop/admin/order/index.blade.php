@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Control Panel @endslot
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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Buyer</th>
                                    <th>Status</th>
                                    <th>Summary</th>
                                    <th>Created At</th>
                                    <th>Updated At</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($orders as $order)
                                    <?php $class = $order->status ? 'success' : '';?>
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
                                        </td>
                                        <td>{{$order->sum}} {{$order->currency}}</td>
                                        <td>{{$order->created_at}}</td>
                                        <td>{{$order->updated_at}}</td>
                                        <td>
                                            <a href="{{route('shop.admin.orders.edit',$order->id)}}" title="Edit">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                            <a href="{{route('shop.admin.orders.forcedelete',$order->id)}}"
                                               title="Delete">
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
                        </div>
                        <div class="text-center">
                            @if ($orders->total() > $orders->count())
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{$orders->links()}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection