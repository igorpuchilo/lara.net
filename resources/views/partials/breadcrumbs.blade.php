@if (count($breadcrumbs))

    <ol class="breadcrumb">
        @foreach ($breadcrumbs as $breadcrumb)

            @if ($breadcrumb->url && !$loop->last)
                <li class="breadcrumb-item"><a class="links" href="{{ $breadcrumb->url }}">
                        @if($breadcrumb->title == 'Home')<i class="fa fa-fw fa-home"></i>{{ $breadcrumb->title }}
                        @elseif($breadcrumb->title == 'Back')<i class="fa fa-fw fa-caret-left"></i>{{ $breadcrumb->title }}
                        @elseif($breadcrumb->title == 'Category')<i class="fa fa-fw fa-caret-right"></i>{{ $breadcrumb->title }}
                        @else<i class="fa fa-fw fa-caret-right"></i>{{ $breadcrumb->title }}
                        @endif
                    </a></li>
            @else
                <li class="breadcrumb-item active">
                    @if($breadcrumb->title == 'Home')<i class="fa fa-fw fa-home"></i>{{ $breadcrumb->title }}
                    @elseif($breadcrumb->title == 'Cart')<i class="fa fa-fw fa-shopping-cart"></i>{{ $breadcrumb->title }}
                    @elseif($breadcrumb->title == 'Profile Edit')<i class="fa fa-fw fa-caret-right"></i>{{ $breadcrumb->title }}
                    @elseif(substr_count($breadcrumb->title, 'Search') > 0)<i class="fa fa-fw fa-search"></i>{{ $breadcrumb->title }}
                    @elseif($breadcrumb->title == 'Back')<i class="fa fa-fw  fa-caret-left"></i>{{ $breadcrumb->title }}
                    @elseif($breadcrumb->title == 'Order History')<i class="fa fa-fw  fa-history"></i>{{ $breadcrumb->title }}
                    @else<i class="fa fa-fw fa-info-circle"></i>{{ $breadcrumb->title }}@endif
                </li>
            @endif

        @endforeach
    </ol>

@endif