<div class="col-md-3">
    <h4>Filter Products</h4>
    <div class="category-filter">
        <form action="">
            <div class="filter">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Sort by:</label>
                    <select class="form-control" id="exampleFormControlSelect1">
                        <option>Price: min - max</option>
                        <option>Price: max - min</option>
                        <option>Alphabetically: A - Z</option>
                        <option>Alphabetically: Z - A</option>
                        <option>Date: Newest - Oldest</option>
                        <option>Date: Oldest - Newest</option>
                    </select>
                </div>
            </div>

            <h5>Brands</h5>
            <div class="filter-pos">
                <div class="form-group">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck01">
                        <label class="form-check-label" for="exampleCheck01">Toyo</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck02">
                        <label class="form-check-label" for="exampleCheck02">Michelin</label>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck03">
                        <label class="form-check-label" for="exampleCheck03">Belshina</label>
                    </div>
                </div>
            </div>
            @foreach($groupfilter as $group)
                <h5>{{$group->title}}</h5>
                <div class="filter-pos">
                    <div class="form-group">
                        @foreach($attributes as $attr)
                            @if($attr->attr_group_id == $group->id)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck01">
                                    <label class="form-check-label" for="exampleCheck01">{{$attr->value}}</label>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="form-group">
                <button type="submit" class="btn btn-dark">Filter Products</button>
                <button type="button" class="btn btn-outline-dark">Reset Filters</button>
            </div>
        </form>
    </div>
</div>