@foreach($items as $item)
        <div class="list-group-item">
            <a href="{{route('shop.admin.categories.edit',$item->id)}}">{{$item->title}}</a>
            <span>
                @if (!($item->hasChildren()))
                <button onclick="location.href='{{url("/admin/categories.mdel?id=$item->id")}}'" class="delete">
                    <i class="fa fa-fw fa-close"></i>
                </button>
                @else
                    <button class="delete disabled" disabled>
                        <i class="fa fa-fw fa-close"></i>
                    </button>
                @endif
            </span>
        </div>
        @if ($item->hasChildren())
            <div class="list-group">
                @include(env('THEME').'shop.admin.category.menu.customMenuItems',['items'=>$item->children()])
            </div>
        @endif

@endforeach