@foreach($items as $item)
    @if ($item->hasChildren())
        <li class="nav-item dropdown">
            <button id="dropdownMenu{{$item->id}}" href="" aria-haspopup="true" aria-expanded="false"
                    class="nav-link dropdown-toggle btn btn-link" data-target="dropdownMenu{{$item->id}}">{{$item->title}}</button>
            <ul aria-labelledby="dropdownMenu{{$item->id}}" class="dropdown-menu border-0 shadow">
                @include('shop.include.menu_child', ['items' => $item->children()])
            </ul>
        </li>
    @else
        <li><a href="{{route('shop.getcategory',$item->data('alias'))}}" class="dropdown-item btn btn-outline-dark btn-link" style="outline: none !important;">{{$item->title}}</a></li>
    @endif
@endforeach