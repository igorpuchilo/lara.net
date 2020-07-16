@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') New Filter Group @endslot
            @slot('parent') Home @endslot
            @slot('group_filter') Filter Groups @endslot
            @slot('active')  New Filter Group @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/filter/group-add')}}" method="POST" data-toggle="validator">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="title">Group Name</label>
                                <input type="text" name="title" class="form-control" id="title" placeholder="Group Name"
                                       value="{{old('title')}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="sel1">Select Category:</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    @foreach($categories as $cat)
                                        <option value="{{$cat->id}}" {{(old('category_id')==$cat->id)? 'selected':''}}>{{$cat->title}}</option>
                                    @endforeach
                                </select>
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