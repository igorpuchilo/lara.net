@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Filters group @endslot
            @slot('parent') Home @endslot
            @slot('active') Filters group @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{url('/admin/filter/group-add')}}" class="btn btn-primary margin-bottom">
                                <i class="fa fa-fw fa-plus"></i>Add Group
                            </a>
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($attrs_group as $attr)
                                    <tr>
                                        <td>{{$attr->category_title}}</td>
                                        <td>{{$attr->title}}</td>
                                        <td>
                                            <a href="{{url('/admin/filter/group-edit', $attr->id)}}"><i
                                                        class="fa fa-fw fa-pencil" title="Edit"></i></a>
                                            <a href="{{url('/admin/filter/group-delete', $attr->id)}}"
                                               class="delete text-danger"><i class="fa fa-fw fa-close text-danger"
                                                                             title="Delete"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection