@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Edit Currency  @endslot
            @slot('parent') Home @endslot
            @slot('currency') Currency List @endslot
            @slot('active') Edit Currency @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/currency/edit', $curr->id)}}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Currency Name</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Currency Name" required value="{{$curr->title}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="code">Currency Code</label>
                                <input type="text" name="code" class="form-control" id="code"
                                       placeholder="Currency Code" required value="{{$curr->code}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="symbol_left">Left Symbol</label>
                                <input type="text" name="symbol_left" class="form-control" id="symbol_left"
                                       placeholder="Left Symbol" value="{{$curr->symbol_left}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="symbol_right">Right Symbol</label>
                                <input type="text" name="symbol_right" class="form-control" id="symbol_right"
                                       placeholder="Right Symbol" value="{{$curr->symbol_right}}">
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="value">Value<small class="text-fuchsia"><br>If Base Enter 1</small></label>
                                <input type="text" name="value" class="form-control" id="value"
                                       placeholder="Value" value="{{$curr->value}}" pattern="^[0-9.]{1,}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="base"><input type="checkbox" name="base"
                                    @if ($curr->base) checked @endif>Base Currency</label>
                            </div>
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