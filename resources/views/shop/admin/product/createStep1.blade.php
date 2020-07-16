@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Create New Product @endslot
            @slot('parent') Home @endslot
            @slot('products') Product List @endslot
            @slot('active') New Product @endslot
        @endcomponent
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <form method="GET" action="{{route('shop.admin.products.create')}}"
                              data-toggle="validator">
                            @csrf
                            <div class="box-body">
                                <div class="form-group has-feedback">
                                    <label for="title">Product Name</label>
                                    <input type="text" name="title" class="form-control" id="title"
                                           placeholder="Product Name" value="{{old('title')}}" required>
                                    <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                                </div>
                                <div class="form-group">
                                    <select name="parent_id" id="parent_id" class="form-control" required>
                                        <option selected="selected">Choose Category</option>
                                        @if (isset($categories))
                                            @foreach($categories as $cat)
                                                <option value="{{$cat->id}}">{{$cat->title}}</option>
                                            @endforeach
                                        @else
                                            <option>Create Category first</option>
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Next Step</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection