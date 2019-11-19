<div class="col-md-3">
    <div class="category-filter">
        <h4>Filter Products</h4>
        <form action="{{route('shop.getcategory',$category->id)}}" method="GET">
            {{--            <h5>Brands</h5>--}}
            {{--            <div class="filter-pos">--}}
            {{--                <div class="form-group">--}}
            {{--                    <div class="form-check">--}}
            {{--                        <input type="checkbox" class="form-check-input" id="exampleCheck01">--}}
            {{--                        <label class="form-check-label" for="exampleCheck01">Toyo</label>--}}
            {{--                    </div>--}}
            {{--                    <div class="form-check">--}}
            {{--                        <input type="checkbox" class="form-check-input" id="exampleCheck02">--}}
            {{--                        <label class="form-check-label" for="exampleCheck02">Michelin</label>--}}
            {{--                    </div>--}}
            {{--                    <div class="form-check">--}}
            {{--                        <input type="checkbox" class="form-check-input" id="exampleCheck03">--}}
            {{--                        <label class="form-check-label" for="exampleCheck03">Belshina</label>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            @if(!empty($groupsfilter))
                @foreach($groupsfilter as $group)
                    <h5>{{$group->title}}</h5>
                    <div class="filter-pos">
                        <div class="form-group">
                            @foreach($attributes as $attr)
                                @if($attr->attr_group_id == $group->id)
                                    <div class="form-check">
                                        {{ Form::checkbox('attrs[]', $attr->id, in_array($attr->id,$attrs),['class' => 'form-check-input'])}}
                                        <label class="form-check-label" for="exampleCheck01">{{$attr->value}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif
            <div class="form-group">
                <button type="submit" id="filterProducts" class="btn btn-dark">Filter Products</button>
                <a href="{{route('shop.getcategory',$category->id)}}" class="btn btn-outline-dark">Reset Filters</a>
            </div>
            <input name="category_id" value="{{$category->id}}" id="{{$category->id}}" hidden>
        </form>
    </div>
</div>