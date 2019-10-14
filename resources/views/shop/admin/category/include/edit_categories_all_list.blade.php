@foreach($categories as $cat)
    <option value="{{$cat->id ?? ""}}"
    @isset($item->id)
        @if ($cat->id == $item->parent_id) selected
        @endif
            @if ($cat->id == $item->id) disabled
        @endif
    @endisset
    >
    {!! $delimiter ?? "" !!} {{$cat->title ?? ""}}
    </option>
    @if (count($cat->children)>0)
        @include('shop.admin.category.include.edit_categories_all_list',
        ['categories' => $cat->children,'delimiter' => ' - '. $delimiter,])
    @endif
@endforeach