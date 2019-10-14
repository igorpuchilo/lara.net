@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') Edit Category @endslot
            @slot('parent') Home @endslot
            @slot('category') Category List @endslot
            @slot('active') Edit Category @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{route('shop.admin.categories.update', $item->id)}}" method="POST"
                          data-toggle="validator">
                        @method('PATCH')
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="titile">Category Name</label>
                                <input type="text" name="title" class="form-control" id="title"
                                       value="{{$item->title}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <select name="parent_id" id="parent_id" class="form-control" required>
                                    <option value="0">--Independent category--</option>
                                    @include('shop.admin.category.include.edit_categories_all_list',
                                    ['categories' => $categories])
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="keywords">Keywords</label>
                                <input type="text" name="keywords" class="form-control" id="keywords"
                                       placeholder="Keywords" value="{{old('keywords',$item->keywords)}}" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Description" value="{{old('description',$item->description)}}" required>
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