@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Edit Product @endslot
            @slot('parent') Home @endslot
            @slot('products') Product List @endslot
            @slot('active') Edit Product @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form method="POST" action="{{route('shop.admin.products.update',$product->id)}}"
                          data-toggle="validator" id="add">
                        @method('PATCH')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Product Name</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       placeholder="Product Name" value="{{$product->title}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <input name="parent_id" value="{{$product->parent_id}}" id="parent_id" hidden>
                                <select name="category_id" id="category_id" class="form-control" required>
                                    @if (isset($categories))
                                        @foreach($categories as $cat)
                                            <option value="{{$cat->id}}" @if($cat->id == $product->category_id)
                                            selected="selected" @endif>{{$cat->title}}</option>
                                        @endforeach
                                    @else
                                        <option>Sub Categories List is empty</option>
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Keywords" value="{{$product->keywords}}">
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Description" value="{{$product->description}}">
                            </div>
                            <div class="form-group has-feedback">
                                <label for="price">Price</label>
                                <input type="text" name="price" class="form-control" id="price"
                                       placeholder="Price" pattern="^[0-9.]{1,}$"
                                       value="{{$product->price}}" required data-error="Only Int and float">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="old_price">Old Price</label>
                                <input type="text" name="old_price" class="form-control" id="old_price"
                                       placeholder="Old Price" pattern="^[0-9.]{1,}$"
                                       value="{{$product->old_price}}" data-error="Only Int and float">
                                <div class="help-block with-errors"></div>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="content">Content</label>
                                <br>
                                <textarea name="content" id="editor1" cols="80"
                                          rows="10">{{$product->content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="status"
                                            {{$product->status ? 'checked' : null}}> Status</label>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="hit"
                                            {{$product->hit ? 'checked' : null}}> Hit</label>
                            </div>
                            <div class="form-group has-feedback">
                                <label for="related">Related Products</label>
                                <select name="related[]" class="select2 form-control" id="related" multiple>
                                    @if (!empty($related))
                                        @foreach($related as $prod)
                                            <option value="{{$prod->related_id}}" selected>
                                                {{$prod->title}}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            {{Widget::run('filter',['tpl'=>'widgets.filter', 'filter' =>$filter,
                            'parent_id' => $product->parent_id])}}
                            <div class="form-group">
                                <div class="col-md-4">
                                    @include('shop.admin.product.include.img_single_edit')
                                </div>
                                <div class="col-md-8">
                                    @include('shop.admin.product.include.img_gallery_edit')
                                </div>
                            </div>
                        </div>

                        <input type="hidden" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="img" value="{{$product->img}}">
                        {{session(['gallery' => $images])}}
                        <div class="box-footer">
                            <button type="submit" class="btn btn-success" name="action" value="save">Save</button>
                            <button type="submit" class="btn btn-warning pull-right" name="action" value="create">Save
                                as New Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class='hidden' data-name='{{$id}}'></div>
    </section>

@endsection