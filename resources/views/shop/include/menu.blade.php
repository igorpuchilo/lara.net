@foreach($items as $item)
    @if ($item->hasChildren())
        <li class="nav-item dropdown">
            <a id="dropdownMenu{{$item->id}}" href="{{route('shop.getcategory',$item->id)}}" aria-haspopup="true" aria-expanded="false"
               class="nav-link dropdown-toggle" data-target="dropdownMenu{{$item->id}}">{{$item->title}}</a>
            <ul aria-labelledby="dropdownMenu{{$item->id}}" class="dropdown-menu border-0 shadow">
             @include('shop.include.menu_child', ['items' => $item->children()])
            </ul>
        </li>
    @else
        <li><a href="{{route('shop.getcategory',$item->id)}}" class="dropdown-item">{{$item->title}}</a></li>
    @endif
@endforeach
