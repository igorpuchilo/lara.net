<?php

namespace App\Http\Controllers\Shop\Admin;


use App\Http\Requests\AdminAttrsFilterAddRequest;
use App\Http\Requests\AdminGroupFilterAddRequest;
use App\Models\Admin\AttributeGroup;
use App\Models\Admin\AttributeValue;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\FilterAttrsRepository;
use App\Repositories\Admin\FilterGroupRepository;
use MetaTag;

class FilterController extends AdminBaseController
{

    private $filterGroupRepository;
    private $filterAttrsRepository;
    private $categoryRepository;

    public function __construct()
    {
        parent::__construct();
        $this->filterAttrsRepository = app(FilterAttrsRepository::class);
        $this->filterGroupRepository = app(FilterGroupRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }
    //show filter groups list
    public function attributeGroup()
    {
        $paginate = 15;
        $attrs_group = $this->filterGroupRepository->getAllGroupsFilterSort($paginate);
        MetaTag::setTags(['title' => 'Filter Groups']);
        return view('shop.admin.filter.attribute-group', compact('attrs_group'));
    }
    // show filter group create form and save action
    public function groupAdd(AdminGroupFilterAddRequest $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->input();
            $group = (new AttributeGroup())->create($data);
            $group->save();
            if ($group) {
                return redirect('/admin/filter/group-add')->with(['success' => 'New group has been Saved'])->withInput();
            } else {
                return back()
                    ->withErrors(['msg' => 'Error on create new group!'])->withInput();
            }
        } else {
            MetaTag::setTags(['title' => 'New Filter Group']);
            $categories = $this->categoryRepository->getParentCategories();
            return view('shop.admin.filter.group-add', compact('categories'));
        }
    }
    //edit filter group form and save action
    public function groupEdit(AdminGroupFilterAddRequest $request, $id)
    {
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        if ($request->isMethod('POST')) {
            $group = AttributeGroup::find($id);
            $group->title = $request->title;
            $group->category_id = $request->category_id;
            $group->save();
            if ($group) {
                return redirect('/admin/filter/group-filter')->with(['success' => 'Saved']);
            } else return back()->withErrors(['msg' => 'Error on change'])->withInput();
        } else {
            $group = $this->filterGroupRepository->getInfoGroup($id);
            MetaTag::setTags(['title' => 'Edit Group']);
            $categories = $this->categoryRepository->getParentCategories();
            return view('shop.admin.filter.group-edit', compact('group','categories'));
        }
    }
    //delete filter group without attributes
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
    //show groups attributes list
    public function attributeFilter()
    {
        $paginate = 15;
        MetaTag::setTags(['title' => 'Group Attributes']);
        $attrs = $this->filterAttrsRepository->getAllAttrsFilter($paginate);
        $count = $this->filterGroupRepository->getCountGroupFilter();
        return view('shop.admin.filter.attribute', compact('attrs', 'count'));
    }
    //show form for adding attribute to groups and save action
    public function attributeAdd(AdminAttrsFilterAddRequest $request)
    {
        if ($request->isMethod('POST')) {
            $uniqName = $this->filterAttrsRepository->checkUnique($request->value, $request->attr_group_id);

            if ($uniqName) return redirect('/admin/filter/attr-add')
                ->withErrors(['msg' => 'This Name Already Exist!'])
                ->withInput();
            $data = $request->input();
            $attr = (new AttributeValue())->create($data);
            $attr->save();

            if ($attr) {
                return redirect('/admin/filter/attr-add')->with(['success' => 'Attribute has been Created'])->withInput();
            } else return back()->withErrors(['msg' => 'Error on create!'])->withInput();

        } else {
            $group = $this->filterGroupRepository->getAllGroupsFilter();
            MetaTag::setTags(['title' => 'New Group Attribute']);
            return view('shop.admin.filter.attrs-add', compact('group'));
        }
    }
    //show attribute edit form and save action
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
            $attr = $this->filterAttrsRepository->getInfoAttribute($id);
            $group = $this->filterGroupRepository->getAllGroupsFilter();

            MetaTag::setTags(['title' => 'Edit Attribute']);
            return view('shop.admin.filter.attrs-edit', compact('attr', 'group'));
        }
    }
    //delete attribute from group
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
