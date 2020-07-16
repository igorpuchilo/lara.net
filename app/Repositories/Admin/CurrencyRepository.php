<?php


namespace App\Repositories\Admin;

use App\Models\Admin\Currency;
use App\Repositories\CoreRepository;
use DB;

class CurrencyRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Currency::class;
    }
    public function getBaseCurrency(){
        return DB::table('currencies')->where('base', '=', '1')->get()->first();
    }
    public function getAllCurrency($paginate)
    {
        return $this->startConditions()
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function switchBaseCurrency()
    {
        $id = DB::table('currencies')->where('base', '=', '1')->get()->first();
        if ($id) {
            $id = $id->id;
            $new = Currency::find($id);
            $new->base = '0';
            $new->save();
            return true;
        } else return false;

    }
    //getId all replace! In parent
    public function getInfoCurrency($id){
        return $this->startConditions()->find($id);
    }
    public function deleteCurrency($id){
        return $this->startConditions()->where('id','=', $id)->forceDelete();
    }
}