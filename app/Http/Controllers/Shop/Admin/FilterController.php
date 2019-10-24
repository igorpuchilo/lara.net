<?php

namespace App\Http\Controllers\Shop\Admin;


use App\Http\Requests\AdminAttrsFilterAddRequest;
use App\Http\Requests\AdminGroupFilterAddRequest;
use App\Models\Admin\AttributeGroup;
use App\Models\Admin\AttributeValue;
use App\Repositories\Admin\FilterAttrsRepository;
use App\Repositories\Admin\FilterGroupRepository;
use MetaTag;

class FilterController extends AdminBaseController
{

    private $filterGroupRepository;
    private $filterAttrsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->filterAttrsRepository = app(FilterAttrsRepository::class);
        $this->filterGroupRepository = app(FilterGroupRepository::class);
    }

    public function attributeGroup()
    {
        $attrs_group = $this->filterGroupRepository->getAllGroupsFilter();
        MetaTag::setTags(['title' => 'Filter Groups']);
        return view('shop.admin.filter.attribute-group', compact('attrs_group'));
    }

    public function groupAdd(AdminGroupFilterAddRequest $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->input();
            $group = (new AttributeGroup())->create($data);
            $group->save();
            if ($group) {
                return redirect('/admin/filter/group-add')->with(['success' => 'New group has been Saved']);
            } else {
                return back()
                    ->withErrors(['msg' => 'Error on create new group!'])->withInput();
            }
        } else {
            MetaTag::setTags(['title' => 'New Filter Group']);
            return view('shop.admin.filter.group-add');
        }
    }

    public function groupEdit(AdminGroupFilterAddRequest $request, $id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        if ($request->isMethod('POST')) {
            $group = AttributeGroup::find($id);
            $group->title = $request->title;
            $group->save();
            if ($group) {
                return redirect('/admin/filter/group-filter')->with(['success' => 'Saved']);
            } else return back()->withErrors(['msg' => 'Error on change'])->withInput();
        } else {
            $group = $this->filterGroupRepository->getInfoProduct($id);
            MetaTag::setTags(['title' => 'Edit Group']);
            return view('shop.admin.filter.group-edit', compact('group'));
        }
    }

    public function groupDelete($id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        $count = $this->filterAttrsRepository->getCountFilterAttrsById($id);
        if ($count) {
            return back()->withErrors(['msg' => 'Group have attributes!']);
        }
        $del = $this->filterGroupRepository->deleteGroupFilter($id);
        if ($del) {
            return back()->with(['success' => 'Group has been deleted']);
        } else return back()->withErrors(['msg' => 'Error on delete!']);
    }

    public function attributeFilter()
    {
        MetaTag::setTags(['title' => 'Group Attributes']);
        $attrs = $this->filterAttrsRepository->getAllAttrsFilter();
        $count = $this->filterGroupRepository->getCountGroupFilter();
        return view('shop.admin.filter.attribute', compact('attrs', 'count'));
    }

    public function attributeAdd(AdminAttrsFilterAddRequest $request)
    {
        if ($request->isMethod('POST')) {
            $uniqName = $this->filterAttrsRepository->checkUnique($request->value);

            if ($uniqName) return redirect('/admin/filter/attr-add')
                ->withErrors(['msg' => 'This Name Already Exist!'])
                ->withInput();
            $data = $request->input();
            $attr = (new AttributeValue())->create($data);
            $attr->save();

            if ($attr) {
                return redirect('/admin/filter/attr-add')->with(['success' => 'Attribute has been Created']);
            } else return back()->withErrors(['msg' => 'Error on create!'])->withInput();

        } else {
            $group = $this->filterGroupRepository->getAllGroupsFilter();
            MetaTag::setTags(['title' => 'New Group Attribute']);
            return view('shop.admin.filter.attrs-add', compact('group'));
        }
    }
    public function attrEdit(AdminAttrsFilterAddRequest $request, $id){
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        if ($request->isMethod('POST')) {
            $attr = AttributeValue::find($id);
            $attr->value = $request->value;
            $attr->attr_group_id = $request->attr_group_id;
            $attr->save();
            if ($attr) {
                return redirect('/admin/filter/attribute-filter')
                    ->with(['success' => 'Attribute has been Changed']);
            } else return back()->withErrors(['msg' => 'Error on change!'])->withInput();
        } else {
            $attr = $this->filterAttrsRepository->getInfoProduct($id);
            $group = $this->filterGroupRepository->getAllGroupsFilter();

            MetaTag::setTags(['title' => 'Edit Attribute']);
            return view('shop.admin.filter.attrs-edit', compact('attr', 'group'));
        }
    }
    public function attrDelete($id){
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        $del = $this->filterAttrsRepository->deleteAttrFilter($id);
        if ($del) {
            return back()
                ->with(['success' => 'Attribute has been Deleted']);
        } else return back()->withErrors(['msg' => 'Error on delete!']);
    }

}
