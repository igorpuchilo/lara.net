@foreach($items as $item)
    <p class="item-p">
        <a class="list-group list-group-item" href="{{route('shop.admin.categories.edit',$item->id)}}">{{$item->title}}</a>
        <span>
            @if (!($item->hasChildren()))
                    <a href="{{url("/admin/categories.mdel?id=$item->id")}}" class="delete">
                        <i class="fa fa-fw fa-close"></i>
                    </a>
                @else
                    <i class="fa fa-fw fa-close"></i>
                @endif
        </span>
    </p>

    @if ($item->hasChildren())
        <div class="list-group list-group-root">
            @include(env('THEME').'shop.admin.category.menu.customMenuItems',['items'=>$item->children()])
        </div>
    @endif
@endforeach