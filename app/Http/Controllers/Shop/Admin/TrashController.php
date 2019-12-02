<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Repositories\Admin\TrashRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use MetaTag;
use Storage;

class TrashController extends AdminBaseController
{
    private $trashRepository;
    public function __construct()
    {
        parent::__construct();
        $this->trashRepository = app(TrashRepository::class);
    }
    public function index()
    {
        MetaTag::setTags(['title'=>'Trash']);
        $paginate = 15;
        $files = $this->trashRepository->getAllFiles($paginate);
        return view('shop.admin.trash',compact('files'));
    }
    public function deleteFile($id){
        $file = $this->trashRepository->getFile($id);
        Storage::disk('public')->delete($file->file);
        if ($this->trashRepository->deleteFile($id)){
            return redirect('/admin/trash')->with(['success' => 'File was deleted!']);
        }else return redirect('/admin/trash')->withErrors(['msg' => 'Delete was Failed!']);

    }
    public function deleteAllFiles(){
        if ($this->trashRepository->deleteAllFiles()){
            return redirect('/admin/trash')->with(['success' => 'Files was deleted!']);
        }else return redirect('/admin/trash')->withErrors(['msg' => 'Delete was Failed!']);
    }
}
