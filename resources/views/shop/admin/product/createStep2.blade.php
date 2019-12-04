@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Create New Product @endslot
            @slot('parent') Home @endslot
            @slot('products') Product List @endslot
            @slot('active') New Product @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form data-toggle="validator" id="add" method="POST" action="{{route('shop.admin.products.store')}}">
                        @method('POST')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Product Name</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Product Name" value="{{old('title')? '' : $data['title']}}"
                                       required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @if (isset($categories))
                                        <option selected="selected">Choose Sub Category</option>
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                                        @endforeach
                                    @else
                                        <option>Sub Categories List is empty</option>
                                    @endif
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
                                <label><input type="checkbox" name="hit" @if(old('hit')) checked @endif> Hit</label>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="related">Related Products</label>
                                <select name="related[]" class="select2 form-control" id="related"
                                        multiple></select>
                            </div>

                            {{Widget::run('filter',['tpl'=>'widgets.filter', 'filter' =>null,
                            'parent_id' => $data['parent_id']])}}

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
                        <input id="parent_id" name="parent_id" value="{{$data['parent_id']}}" hidden>
                        <div class="box-footer">
                            <button type="submit" form="add" class="btn btn-success">Save</button>
                            <a class="btn btn-warning" href="{{route('shop.admin.products.createStep1')}}">Previous
                                Step</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection