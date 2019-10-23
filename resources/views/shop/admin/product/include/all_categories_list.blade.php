@foreach($categories as $cat_list)
    <option
            value="{{$cat_list->id ?? ""}}"
            @isset($item->id)
            @if ($cat_list->id == $item->parent_id) selected @endif
            @if ($item->id== $cat_list->id) disabled @endif
            @endisset>
        {!! $delimiter ?? "" !!} {{$cat_list->title ?? ""}}
    </option>
    @if (count($cat_list->children) > 0)
        @include('shop.admin.category.include.edit_categories_all_list',
        [
        'categories' => $cat_list->children,
        'delimiter' => ' - ' . $delimiter,
        ])
    @endif
@endforeach