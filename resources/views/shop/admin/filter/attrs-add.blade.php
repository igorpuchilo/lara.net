@extends('layouts.app_admin')

@section('content')
    <section class="content-header">
        @component('shop.admin.components.breadcrumb')
            @slot('title') New Group Attributes @endslot
            @slot('parent') Home @endslot
            @slot('attrs_filter') Group Attributes @endslot
            @slot('active')  New Group Attributes @endslot
        @endcomponent
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <form action="{{url('/admin/filter/attr-add')}}" method="POST" data-toggle="validator"
                          id="addattrs">
                        @csrf
                        <div class="box-body">
                            <div class="form-group has-feedback">
                                <label for="value">Attribute Name</label>
                                <input type="text" name="value" class="form-control" id="value"
                                       placeholder="Attribute Name" value="{{old('value')}}" required>
                                <span class="glyphicon form-control-feedback" aria-hidden="true"></span>
                            </div>
                            <div class="form-group">
                                <label for="attr_group_id">Attribute Group</label>
                                <select name="attr_group_id" class="form-control" id="attr_group_id">
                                    <option>Choose Group</option>
                                    @foreach ($group as $item)
                                        <option value="{{$item->id}}" {{(old('attr_group_id')==$item->id)? 'selected':''}}>
                                            {{$item->category_title}}  >>  {{$item->title}}
                                        </option>
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