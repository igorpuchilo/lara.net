@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Group Attributes @endslot
            @slot('parent') Home @endslot
            @slot('active') Group Attributes @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{url('/admin/filter/attr-add')}}" class="btn btn-primary margin-bottom">
                                <i class="fa fa-fw fa-plus"></i>Add Attribute
                            </a>
                            @if(!$attrs->isEmpty())
                                <table class="table table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>@sortablelink('id')</th>
                                        <th>@sortablelink('value','Name')</th>
                                        <th>@sortablelink('groups','Group')</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($attrs as $attr)
                                        <tr>
                                            <td>{{$attr->id}}</td>
                                            <td>{{$attr->value}}</td>
                                            <td>{{$attr->category_title}} <i class="fa fa-fw fa-long-arrow-right"></i> {{$attr->group_title}}</td>
                                            <td>
                                                <a href="{{url('/admin/filter/attr-edit', $attr->id)}}"><i
                                                            class="fa fa-fw fa-pencil" title="Edit"></i></a>
                                                <a href="{{url('/admin/filter/attr-delete', $attr->id)}}"
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
                            {!! $attrs->appends(\Request::except('page'))->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection