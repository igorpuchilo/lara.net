@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Control Panel @endslot
            @slot('parent') Home @endslot
            @slot('active') @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h4>Total Orders: {{$countOrders}}</h4>
                        <p>New Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="{{route('shop.admin.orders.index')}}" class="small-box-footer">More info<i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h4>Total Products: {{$countProducts}}</h4>
                        <p>Products</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('/admin/products')}}" class="small-box-footer">More info<i
                                class="fa fa-arrow-circle-right"></i> </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Total Users: {{$countUsers}}</h4>
                        <p>User Registration</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="{{route('shop.admin.users.index')}}" class="small-box-footer">More info<i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h4>Total Categories: {{$countCategories}}</h4>
                        <p>Categories</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{route('shop.admin.categories.index')}}" class="small-box-footer">More info<i
                                class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>

            <div class="col-md-12">
                @include('shop.admin.main.include.orders')
                @include('shop.admin.main.include.recently')
            </div>
        </div>
    </section>
@endsection