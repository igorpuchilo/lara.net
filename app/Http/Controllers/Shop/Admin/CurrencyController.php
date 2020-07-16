<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Requests\AdminCurrencyRequest;
use App\Models\Admin\Currency;
use App\Repositories\Admin\CurrencyRepository;
use MetaTag;

class CurrencyController extends AdminBaseController
{
    private $currencyRepository;

    public function __construct()
    {
        parent::__construct();
        $this->currencyRepository = app(CurrencyRepository::class);
    }
    //show currency list
    public function index()
    {
        $paginate = 15;
        $curr = $this->currencyRepository->getAllCurrency($paginate);

        MetaTag::setTags(['title' => 'Currency']);
        return view('shop.admin.currency.index',compact('curr'));
    }
    //add form and save to base action
    public function add(AdminCurrencyRequest $request){
        if($request->isMethod('POST')){
            $data = $request->input();
            $curr = (new Currency())->create($data);
            if ($request->base == 'on'){
                if ($this->currencyRepository->switchBaseCurrency()){
                    $curr->base = '1';
                }else {
                    return back()->withErrors(['msg' => 'Base currency not found!'])->withInput();
                }
            }
            $curr->save();
            if($curr){
                return redirect('/admin/currency/add')->with(['success' => 'Saved']);
            }else return back()->withErrors(['msg' => 'Error on create!'])->withInput();
        } else {
            MetaTag::setTags(['title' => 'Add Currency']);
            return view('shop.admin.currency.add');
        }
    }
    //edit currency form and save action
    public function edit(AdminCurrencyRequest $request, $id){
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        if($request->isMethod('POST')){
            $curr = Currency::find($id);
            $curr->title = $request->title;
            $curr->code = $request->code;
            $curr->symbol_left = $request->symbol_left;
            $curr->symbol_right = $request->symbol_right;
            $curr->value = $request->value;
            $curr->base = $request->base ? '1' : '0';
            $curr->save();
            if($curr){
                return redirect('/admin/currency/index')->with(['success' => 'Saved']);
            }else return back()->withErrors(['msg' => 'Error on create!'])->withInput();
        } else {
            $curr = $this->currencyRepository->getInfoCurrency($id);
            MetaTag::setTags(['title' => 'Edit Currency']);
            return view('shop.admin.currency.edit', compact('curr'));
        }
    }
    //delete currency action
    public function delete($id){
        if (empty($id)) {
            return back()->withErrors(['msg' => 'Item Not found!']);
        }
        if ($this->currencyRepository->getBaseCurrency()->id == $id){
            return back()->withErrors(['msg' => 'This is Base Currency!']);
        }
        $del = $this->currencyRepository->deleteCurrency($id);
        if ($del) {
            return back()->with(['success' => 'Currency has been deleted']);
        } else return back()->withErrors(['msg' => 'Error on delete!']);
    }
}
