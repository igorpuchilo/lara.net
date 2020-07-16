<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Requests\SettingsRequest;
use App\Repositories\Admin\SettingsRepository;
use Illuminate\Http\Request;
use MetaTag;

class SettingsController extends AdminBaseController
{
    private $settingsRepository;
    public function __construct()
    {
        parent::__construct();
        $this->settingsRepository = app(SettingsRepository::class);
    }
    public function index()
    {
        MetaTag::setTags(['title'=>'Store Settings']);
        $paginate = 15;
        $settings = $this->settingsRepository->getAllSettings($paginate);
        return view('shop.admin.settings.index',compact('settings'));
    }
    public function edit($id)
    {
        MetaTag::setTags(['title'=>'Edit Parameter']);
        $param = $this->settingsRepository->getParamById($id);
        return view('shop.admin.settings.edit',compact('param'));
    }
    public function save(Request $request)
    {
        $setting = $this->settingsRepository->getParamById($request->id);
        $setting->param_description = $request->param_description;
        $setting->value = $request->value;
        if($setting->save()){
            $paginate = 15;
            $settings = $this->settingsRepository->getAllSettings($paginate);
            return view('shop.admin.settings.index',compact('settings'))->with(['success' => 'Saved!']);
        }else return back()->withInput()->withErrors(['msg' => 'Error on Save!']);

    }
}
