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
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Group</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($attrs as $attr)
                                    <tr>
                                        <td>{{$attr->id}}</td>
                                        <td>{{$attr->value}}</td>
                                        <td>{{$attr->category_title}}</td>
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
                        </div>
                        <div class="text-center">
                            <p>@php echo count($attrs) @endphp of {{$count}}</p>
                            {{$attrs}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection