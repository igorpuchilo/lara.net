@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Store Settings @endslot
            @slot('parent') Home @endslot
            @slot('active') Store Settings @endslot
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
                                    <th class="text-center">Id</th>
                                    <th class="text-center">Parameter Name</th>
                                    <th class="text-center">Parameter Description</th>
                                    <th class="text-center">Value</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!$settings->isEmpty())
                                    @foreach($settings as $param)
                                        <tr>
                                            <td>{{$param->id}}</td>
                                            <td>{{$param->param_name}}</td>
                                            <td>{{$param->param_description}}</td>
                                            <td>{!! $param->value !!}</td>
                                            <td class="text-center">
                                                <a class="btn btn-success"
                                                   href="{{route('shop.admin.settings.edit',$param->id)}}"
                                                   title="Edit This Value">Edit This Parameter</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="text-center" colspan="3"><h2>No Parameters found</h2></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>

                        </div>
                        <div class="text-center">
                            @if ($settings->total() > $settings->count())
                                <br>
                                <div class="row justify-content-center">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                {{$settings->links()}}
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