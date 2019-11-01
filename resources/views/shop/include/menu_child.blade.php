@foreach($items as $item)
    @if(!($item->hasChildren()))
        <li><a href="#" class="dropdown-item">{{$item->title}}</a></li>
    @else
        <li class="dropdown-submenu">
            <a id="dropdownMenu{{$item->id}}" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
               aria-expanded="false" class="dropdown-item dropdown-toggle">{{$item->title}}</a>
            <ul aria-labelledby="dropdownMenu{{$item->id}}" class="dropdown-menu border-0 shadow">
                @include('shop.include.menu_child', ['items' => $item->children()])
            </ul>
        </li>
    @endif
@endforeach