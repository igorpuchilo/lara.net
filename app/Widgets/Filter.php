<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use DB;

class Filter extends AbstractWidget
{
    public $groups;
    public $attrs;
    public $tpl;
    public $filter;
    public $parent_id;
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->filter = $this->config['filter'];
        $this->tpl = $this->config['tpl'];
        $this->parent_id = $this->config['parent_id'];
    }

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $this->groups = $this->getGroups();
        $this->attrs = $this->getAttrs();


        return view($this->tpl, [
            'config' => $this->config,
            'groups' => $this->groups,
            'attrs' => $this->attrs,
            'filter' => $this->filter,
            'parent_id' => $this->parent_id,
        ]);
    }
    protected function getGroups(){
        $data = DB::table('attribute_groups')
            ->join('attribute_values', 'attribute_groups.id', '=',
                'attribute_values.attr_group_id')
            ->select('attribute_groups.*')
            ->where('category_id','=',$this->parent_id)
            ->get();
        $groups = [];
        foreach ($data as $key => $value){
            $groups[$value->id] = $value->title;
        }
        return $groups;
    }
    protected function getAttrs(){
        $data = DB::table('attribute_values')->get();
        $attrs = [];
        foreach ($data as $key => $value){
            $attrs[$value->attr_group_id][$value->id] = $value->value;
        }
        return $attrs;
    }
    public function getFilter(){
        $filter = null;
    }
}
