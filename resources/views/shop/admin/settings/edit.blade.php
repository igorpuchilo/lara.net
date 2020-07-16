@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Edit Parameter  @endslot
            @slot('parent') Home @endslot
            @slot('settings') Settings List @endslot
            @slot('active') Edit Parameter @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route('shop.admin.settings.save')}}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Parameter Description</label>
                                <input type="text" name="param_description" class="form-control" id="param_description"
                                       placeholder="Parameter Description" required value="{{$param->param_description}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="content">Value</label>
                                <br>
                                <textarea name="value" id="editor1" cols="80"
                                          rows="10">{{$param->value}}</textarea>
                            </div>
                            <input name="id" value="{{$param->id}}" hidden>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection