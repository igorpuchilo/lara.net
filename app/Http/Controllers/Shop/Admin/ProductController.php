<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Requests\AdminProductsCreateRequest;
use App\Models\Admin\Category;
use App\Models\Admin\Product;
use App\Repositories\Admin\ProductRepository;
use App\Shop\Core\ShopApp;
use Illuminate\Http\Request;
use MetaTag;

class ProductController extends AdminBaseController
{
    private $productRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
    }

    /**
     * Products List
     */
    public function index()
    {
        MetaTag::setTags(['title' => 'Product list']);
        $paginate = 10;
        $allProducts = $this->productRepository->getAllProducts($paginate);
        $countProducts = $this->productRepository->getCountProducts();
        return view('shop.admin.product.index', compact('allProducts', 'countProducts'));
    }

    /**
     * Create new product form
     */
    public function create()
    {
        MetaTag::setTags(['title' => 'Create New Product']);

        $item = new Category();

        return view('shop.admin.product.create', ['categories' => Category::with('children')
            ->where('parent_id', '=', '0')->get(), 'delimiter' => '-', 'item' => $item,]);
    }

    /**
     * Store a newly created product
     */
    public function store(AdminProductsCreateRequest $request)
    {
        $data = $request->input();
        $product = (new Product())->create($data);
        $id = $product->id;
        $product->status = $request->status ? '1' : '0';
        $product->hit = $request->hit ? '1' : '0';
        $product->category_id = $request->parent_id ?? '0';
        $this->productRepository->getImg($product);
        $save = $product->save();
        if ($save) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            return redirect()
                ->route('shop.admin.products.create', [$product->id])
                ->with(['success' => 'Saved']);
        } else {
            return back()
                ->withErrors(['msg' => 'Error on save!'])
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing product
     */
    public function edit($id)
    {
        MetaTag::setTags(['title' => 'Edit Exist Product']);

        $product = $this->productRepository->getInfoProduct($id);
        ShopApp::get_Instance()->setProperty('parent_id', $product->category_id);
        $filter = $this->productRepository->getFiltersProduct($id);
        $related = $this->productRepository->getRelatedProducts($id);
        $images = $this->productRepository->getGallery($id);
        return view('shop.admin.product.edit', compact('product', 'filter', 'related', 'images', 'id'),
            ['categories' => Category::with('children')
                ->where('parent_id', '=', '0')->get(), 'delimiter' => '-',
                'product' => $product,]);
    }

    /**
     * Update the specified product
     */
    public function update(AdminProductsCreateRequest $request, $id)
    {
        $product = $this->productRepository->getId($id);
        if(empty($product)){
            return back()
                ->withErrors(['msg' => 'Product not found!'])
                ->withInput();
        }
        $data = $request->all();
        $result = $product->update($data);
        $product->status = $request->status ? '1' : '0';
        $product->hit = $request->hit ? '1' : '0';
        $product->category_id = $request->parent_id ?? $product->category_id;
        $this->productRepository->getImg($product);
        $save = $product->save();
        if ($save && $result) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            return redirect()
                ->route('shop.admin.products.edit', [$id])
                ->with(['success' => 'Saved']);
        } else {
            return back()
                ->withErrors(['msg' => 'Error on save!'])
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    // change status product to OFF
    public function deleteStatus($id)
    {
        if($id){
            $status = $this->productRepository->deleteStatusOne($id);
            if($status){
                return redirect()
                    ->route('shop.admin.products.index')
                    ->with(['success' => 'Saved']);
            }else
            {
                return back()->withErrors(['msg'=>'Error on save'])->withInput();
            }
        }
    }
    // Get status current product On/Off
    public function getStatus($id)
    {
        if($id){
            $status = $this->productRepository->getStatusOne($id);
            if($status){
                return redirect()
                    ->route('shop.admin.products.index')
                    ->with(['success' => 'Saved']);
            }else
            {
                return back()->withErrors(['msg'=>'Error on save'])->withInput();
            }
        }
    }
    //delete product with all path
    public function deleteProduct($id){
        if($id) {
            $this->productRepository->deleteImgGalleryFromPath($id);
            $db = $this->productRepository->deleteFromDB($id);
            if($db){
                return redirect()
                    ->route('shop.admin.products.index')
                    ->with(['success' => 'Saved']);
            }else
            {
                return back()->withErrors(['msg'=>'Error on save'])->withInput();
            }
        }
    }
    //Search related product method sql LIKE
    public function related(Request $request)
    {
        $q = isset($request->q) ? htmlspecialchars(trim($request->q)) : '';
        $data['items'] = [];
        $products = $this->productRepository->getProducts($q);
        if ($products) {
            $i = 0;
            foreach ($products as $id => $title) {
                $data['items'][$i]['id'] = $title->id;
                $data['items'][$i]['text'] = $title->title;
                $i++;
            }
        }
        echo json_encode($data);
        die;
    }
    //upload image to storage
    public function ajaxImage(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('shop.admin.product.include.image_single_edit');
        } else {
            $valid = \Validator::make($request->all(),
                [
                    'file' => 'image|max:3000',
                ]);
            if ($valid->fails()) {
                return array('fail' => true, 'errors' => $valid->errors());
            }
        }
        $extens = $request->file('file')->getClientOriginalExtension();
        $dir = 'uploads/single/';
        $filename = uniqid() . '_' . time() . '.' . $extens;
        $request->file('file')->move($dir, $filename);
        $wmax = ShopApp::get_Instance()->getProperty('img_width');
        $hmax = ShopApp::get_Instance()->getProperty('img_height');
        $this->productRepository->uploadImg($filename, $wmax, $hmax);
        return $filename;
    }
    //delete image from storage
    public function deleteImage($filename)
    {
        \File::delete('uploads/single/' . $filename);
    }
    // upload to gallery
    public function gallery(Request $request)
    {
        $valid = \Validator::make($request->all(),
            [
                'file' => 'image|max:3000',
            ]);
        if ($valid->fails()) {
            return array('fail' => true, 'errors' => $valid->errors());
        }
        if (isset($_GET['upload'])) {
            $wmax = ShopApp::get_Instance()->getProperty('gallery_width');
            $hmax = ShopApp::get_Instance()->getProperty('gallery_height');
            $name = $_POST['name'];
            $this->productRepository->uploadGallery($name, $wmax, $hmax);
        }
    }
    //delete all files from gallery
    public function deleteGallery()
    {
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        if (!$id || !$src) {
            return;
        }
        if (\DB::delete("DELETE FROM galleries WHERE product_id = ? AND img = ?", [$id, $src])) {
            @unlink("uploads/gallery/$src");
            exit('1');
        }
        return;
    }
}