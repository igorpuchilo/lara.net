@foreach($items as $item)
    @if(!($item->hasChildren()))
        <li><a href="{{route('shop.getcategory',$item->data('alias'))}}" class="dropdown-item">{{$item->title}}</a></li>
    @else
        <li class="dropdown-submenu">
            <a id="dropdownMenu{{$item->id}}" href="{{route('shop.getcategory',$item->data('alias'))}}" role="button" aria-haspopup="true"
               aria-expanded="false" class="dropdown-item dropdown-toggle">{{$item->title}}</a>
            <ul aria-labelledby="dropdownMenu{{$item->id}}" class="dropdown-menu border-0 shadow">
                @include('shop.include.menu_child', ['items' => $item->children()])
            </ul>
        </li>
    @endif
@endforeach