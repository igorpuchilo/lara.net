<?php


namespace App\Repositories\Admin;


use App\Models\Admin\StoreSettings;
use App\Repositories\CoreRepository;

class SettingsRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function getModelClass()
    {
        return StoreSettings::class;
    }
    public function getAllSettings($paginate){
        return $this->startConditions()->limit($paginate)->paginate($paginate);
    }
    public function getParamById($id){
        return $this->startConditions()->find($id);
    }
    public function getParamByName($name){
        return $this->startConditions()->where('param_name',$name)->first();
    }
    public function getValueByName($name){
        return $this->startConditions()->where('name',$name)->select('value')->first();
    }

}