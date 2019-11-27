<?php


namespace App\Repositories\Admin;


use App\Models\Admin\Trash;
use App\Repositories\CoreRepository;
use Storage;
use DB;

class TrashRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }
    protected function getModelClass()
    {
        return Trash::class;
    }
    public function getAllFiles($paginate){
        $gallerys = $files = Storage::files('/uploads/gallery');
        $singles = $files = Storage::files('/uploads/single');
        foreach ($gallerys as $gal){
            if(substr_count(basename($gal),'thumb-')||substr_count(basename($gal),'preview-')){
                $clrname = str_replace(array('thumb-','preview-'),'',basename($gal));
                $tmp = DB::table('galleries')->where('img',$clrname)->count();
                if($tmp == 0){
                    $this->startConditions()->firstOrCreate(['file' => $gal]);
                }
            }else{
                $tmp = DB::table('galleries')->where('img',basename($gal))->count();
                if($tmp == 0){
                    $this->startConditions()->firstOrCreate(['file' => $gal]);
                }
            }

        }
        foreach ($singles as $single){
            $tmp = DB::table('products')->where('img',basename($single))->count();
            if($tmp == 0){
                $this->startConditions()->firstOrCreate(['file' => $single]);
            }
        }
        return $this->startConditions()
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }
    public function getFile($id){
        return $this->startConditions()->find($id);
    }
    public function deleteFile($id){
        return $this->startConditions()->where('id',$id)->delete();
    }
    public function deleteAllFiles(){
        $files = $this->startConditions()::all();
        foreach ($files as $file){
            Storage::disk('public')->delete($file->file);
        }
        return $this->startConditions()->truncate();
    }
}