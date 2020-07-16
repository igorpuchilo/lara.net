<h1>
    @if (isset($title)) {{$title}}@endif
</h1>
<ol class="breadcrumb">
    <li><a href="{{route('shop.admin.index.index')}}"><i class="fa fa-home"></i>{{$parent}}</a></li>
    @if (isset($order))
        <li><a href="{{route('shop.admin.orders.index')}}"><i class="fa fa-list"></i>{{$order}}</a> </li>
    @endif
    @if (isset($category))
        <li><a href="{{route('shop.admin.categories.index')}}"><i class="fa fa-navicon"></i>{{$category}}</a> </li>
    @endif
    @if (isset($user))
        <li><a href="{{route('shop.admin.users.index')}}"><i class="fa fa-users"></i>{{$user}}</a> </li>
    @endif
    @if (isset($products))
        <li><a href="{{route('shop.admin.products.index')}}"><i class="fa fa-list"></i>{{$products}}</a> </li>
    @endif
    @if (isset($group_filter))
        <li><a href="{{route('shop.admin.filter.group-filter')}}"><i class="fa fa-filter"></i>{{$group_filter}}</a> </li>
    @endif
    @if (isset($attrs_filter))
        <li><a href="{{route('shop.admin.filter.attribute-filter')}}"><i class="fa fa-filter"></i>{{$attrs_filter}}</a> </li>
    @endif
    @if (isset($currency))
        <li><a href="{{route('shop.admin.currency.index')}}"><i class="fa fa-usd"></i>{{$currency}}</a> </li>
    @endif
    @if (isset($settings))
        <li><a href="{{route('shop.admin.settings.index')}}"><i class="fa fa-cogs"></i>{{$settings}}</a> </li>
    @endif
    <li><i class="active"></i>{{$active}}</li>
</ol>