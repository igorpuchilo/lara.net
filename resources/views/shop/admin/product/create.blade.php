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
                        <form method="POST" action="{{route('shop.admin.products.store',$item->id)}}"
                              data-toggle="validator" id="add">
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
                                        <option>-- Choose Category --</option>
                                        @include('shop.admin.product.include.all_categories_list',
                                        ['categories'=>$categories])
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="keywords">Keywords</label>
                                    <input type="text" name="keywords" class="form-control" id="keywords"
                                           placeholder="Keywords" value="{{old('keywords')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" class="form-control" id="description"
                                           placeholder="Description" value="{{old('description')}}">
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="price">Price</label>
                                    <input type="text" name="price" class="form-control" id="price"
                                           placeholder="Price" pattern="^[0-9.]{1,}$"
                                           value="{{old('price')}}" required data-error="Only Int and float">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="old_price">Old Price</label>
                                    <input type="text" name="old_price" class="form-control" id="old_price"
                                           placeholder="Old Price" pattern="^[0-9.]{1,}$"
                                           value="{{old('old_price')}}" data-error="Only Int and float">
                                    <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="content">Content</label>
                                    <br>
                                    <textarea name="content" id="editor1" cols="80"
                                              rows="10">{{old('content')}}</textarea>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="status" checked> Status</label>
                                </div>
                                <div class="form-group">
                                    <label><input type="checkbox" name="hit"> Hit</label>
                                </div>
                                <div class="form-group has-feedback">
                                    <label for="related">Related Products</label>
                                    <select name="related[]" class="select2 form-control" id="related" multiple></select>
                                </div>
                                <div class="form-group">
                                    <label>Product Filters</label>
                                    {{Widget::run('filter',['tpl'=>'widgets.filter', 'filter' =>null,])}}
                                </div>

                                <div class="form-group">
                                    <div class="col-md-4">
                                        @include('shop.admin.product.include.img_single_create')
                                    </div>
                                    <div class="col-md-8">
                                        @include('shop.admin.product.include.img_gallery_create')
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id="_token" value="{{ csrf_token() }}">
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </section>
@endsection