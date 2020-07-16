@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Product List @endslot
            @slot('parent') Home @endslot
            @slot('active') Product List @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            @if(!$allProducts->isEmpty())
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@sortablelink('id','ID')</th>
                                        <th>@sortablelink('category','Category')</th>
                                        <th>@sortablelink('title','Product Name')</th>
                                        <th>@sortablelink('price')</th>
                                        <th>@sortablelink('status')</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($allProducts as $product)
                                        <tr>
                                            <td>{{$product->id}}</td>
                                            <td>{{$product->category}}</td>
                                            <td>{{$product->title}}</td>
                                            <td>{{$product->price}}</td>
                                            <td>{{$product->status ? 'On' : 'Off'}}</td>
                                            <td><a href="{{route('shop.admin.products.edit',$product->id)}}"
                                                   title="Edit">
                                                    <i class="fa fa-fw fa-pencil"></i>
                                                </a>
                                                @if ($product->status == 0)
                                                    <a href="{{route('shop.admin.products.getstatus',$product->id)}}"
                                                       title="Switch on"><i
                                                                class="fa fa-fw fa-refresh"></i></a>
                                                @else
                                                    <a href="{{route('shop.admin.products.deletestatus',$product->id)}}"
                                                       title="Turn Off"><i class="fa fa-fw fa-close"></i></a>
                                                @endif

                                                @if ($product)
                                                    <a class="delete"
                                                       href="{{route('shop.admin.products.deleteproduct',$product->id)}}"
                                                       title="Delete from DB"><i
                                                                class="fa fa-fw fa-close text-danger"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <br><span class="warning text-center"><i
                                            class="fa fa-fw fa-warning"></i>No Data To View!</span>
                            @endif
                        </div>
                        <div class="text-center">
                            {!! $allProducts->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection