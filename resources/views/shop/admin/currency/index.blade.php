@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Currency List @endslot
            @slot('parent') Home @endslot
            @slot('active') Currency List @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{url('/admin/currency/add')}}" class="btn btn-primary margin-bottom">
                                <i class="fa fa-fw fa-plus"></i>Add Currency
                            </a>
                            @if(!$curr->isEmpty())
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@sortablelink('id','Id')</th>
                                        <th>@sortablelink('title','Currency Name')</th>
                                        <th>@sortablelink('code','Code')</th>
                                        <th>@sortablelink('value','Value')</th>
                                        <th>@sortablelink('base', 'Is Base Currency')</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($curr as $val)
                                        <tr>
                                            <td>{{$val->id}}</td>
                                            <td>{{$val->title}}</td>
                                            <td>{{$val->code}}</td>
                                            <td>{{$val->value}}</td>
                                            <td>@if ($val->base == 1) YES @else NO @endif</td>
                                            <td>
                                                <a href="{{url('/admin/currency/edit', $val->id)}}"><i
                                                            class="fa fa-fw fa-pencil" title="Edit"></i></a>
                                                <a href="{{url('/admin/currency/delete', $val->id)}}"
                                                   class="delete text-danger"><i class="fa fa-fw fa-close text-danger"
                                                                                 title="Delete"></i></a>
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
                            {!! $curr->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection