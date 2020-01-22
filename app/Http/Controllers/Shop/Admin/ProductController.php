<?php

namespace App\Http\Controllers\Shop\Admin;

use App\Http\Requests\AdminProductsCreateRequest;
use DB;
use App\Models\Admin\Product;
use App\Repositories\Admin\CategoryRepository;
use App\Repositories\Admin\FilterAttrsRepository;
use App\Repositories\Admin\ProductRepository;
use App\Shop\Core\ShopApp;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use MetaTag;
use Storage;

class ProductController extends AdminBaseController
{
    private $productRepository;
    private $categoryRepository;
    private $filterAttrsRepository;

    public function __construct()
    {
        parent::__construct();
        $this->productRepository = app(ProductRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->filterAttrsRepository = app(FilterAttrsRepository::class);
    }

    /**
     * Products List
     */
    public function index()
    {
        MetaTag::setTags(['title' => 'Product list']);
        $paginate = 15;
        $allProducts = $this->productRepository->getAllProducts($paginate);
        $countProducts = $this->productRepository->getCountProducts();
        return view('shop.admin.product.index', compact('allProducts', 'countProducts'));
    }

    /**
     * Create new product form
     */
    public function createStep1()
    {
        $categories = $this->categoryRepository->getParentCategories();
        return view('shop.admin.product.createStep1', compact('categories'));
    }

    public function create(Request $request)
    {
        MetaTag::setTags(['title' => 'Create New Product']);
        $parent_id = $request->parent_id;
        $categories = $this->categoryRepository->getSubCategories($parent_id);
        $filter = $this->filterAttrsRepository->getAllAttrsFilterByParentId($parent_id);
        $data = $request->input();
        return view('shop.admin.product.createStep2', compact('data', 'categories', 'filter', 'parent_id'));

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
        $product->category_id = $request->category_id ?? '0';
        $product->parent_id = $request->parent_id;
        $this->productRepository->getImg($product);
        $save = $product->save();
        if ($save) {
            $this->productRepository->editFilter($id, $data);
            $this->productRepository->editRelatedProduct($id, $data);
            $this->productRepository->saveGallery($id);
            return redirect()->route('shop.admin.products.edit', $id)->with(['success' => 'Saved']);
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
        $filter = $this->productRepository->getFiltersProduct($id);
        $categories = $this->categoryRepository->getSubCategories($product->parent_id);
        $related = $this->productRepository->getRelatedProducts($id);
        $images = $this->productRepository->getGallery($id);
        return view('shop.admin.product.edit', compact('product', 'filter', 'related', 'images', 'id', 'categories'));
    }

    /**
     * Update the specified product
     */
    public function update(AdminProductsCreateRequest $request, $id)
    {
        switch ($request->input('action')) {
            case 'save':
                $product = $this->productRepository->getId($id);
                if (empty($product)) {
                    return back()
                        ->withErrors(['msg' => 'Product not found!'])
                        ->withInput();
                }

                $data = $request->all();
                $result = $product->update($data);
                $product->status = $request->status ? '1' : '0';
                $product->hit = $request->hit ? '1' : '0';
                $product->category_id = $request->category_id;
                $this->productRepository->getImg($product);
                $save = $product->save();
                if ($save && $result) {
                    $this->productRepository->updatePrice($id,$data['price']);
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
                break;
            case 'create':
                $data = $request->all();
                $product = (new Product())->create($data);
                $id = $product->id;
                $product->status = $request->status ? '1' : '0';
                $product->hit = $request->hit ? '1' : '0';
                $product->category_id = $request->category_id ?? '0';
                $product->parent_id = $request->parent_id;
                $this->productRepository->getImg($product);
                $save = $product->save();
                if ($save) {
                    $this->productRepository->editFilter($id, $data);
                    $this->productRepository->editRelatedProduct($id, $data);
                    $this->productRepository->saveGallery($id);
                    return redirect()->route('shop.admin.products.edit', $id)->with(['success' => 'Saved']);
                } else {
                    return back()
                        ->withErrors(['msg' => 'Error on save!'])
                        ->withInput();
                }
                break;
        }
        return back()->withErrors(['msg'=>'Error on save!']);
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
        if ($id) {
            $status = $this->productRepository->deleteStatusOne($id);
            if ($status) {
                return redirect()
                    ->route('shop.admin.products.index')
                    ->with(['success' => 'Saved']);
            } else {
                return back()->withErrors(['msg' => 'Error on save'])->withInput();
            }
        }
    }

    // Get status current product On/Off
    public function getStatus($id)
    {
        if ($id) {
            $status = $this->productRepository->getStatusOne($id);
            if ($status) {
                return redirect()
                    ->route('shop.admin.products.index')
                    ->with(['success' => 'Saved']);
            } else {
                return back()->withErrors(['msg' => 'Error on save'])->withInput();
            }
        }
    }

    //delete product with all path
    public function deleteProduct($id)
    {
        if ($id) {
            $this->productRepository->deleteImgGalleryFromPath($id);
            $db = $this->productRepository->deleteFromDB($id);
            if ($db) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with(['success' => "Product[$id] was deleted for DataBase"]);
            } else {
                return back()->withErrors(['msg' => 'Error on save'])->withInput();
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
        $filename = uniqid() . '.' . $extens;
        $uploadfile = $dir . $filename;
        $image = Image::make($request->file('file'))->resize(null, 200, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg');
        Storage::put($uploadfile, $image->encode());
        \Session::put('single', $filename);
        return $filename;
    }

    //delete image from storage
    public function deleteImage($filename)
    {
        $this->productRepository->delImgIfExist($filename);
        Storage::disk('public')->delete('uploads/single/' . $filename);
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
            $thumb_wmax = ShopApp::get_Instance()->getProperty('thumb_gallery_width');
            $thumb_hmax = ShopApp::get_Instance()->getProperty('thumb_gallery_height');
            $preview_wmax = ShopApp::get_Instance()->getProperty('preview_gallery_width');
            $preview_hmax = ShopApp::get_Instance()->getProperty('preview_gallery_height');
            $name = $_POST['name'];
            $this->productRepository->uploadGallery($name, $wmax, $hmax, $thumb_wmax, $thumb_hmax, $preview_wmax, $preview_hmax);
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
            Storage::disk('public')
                ->delete(['uploads/gallery/' . $src, 'uploads/gallery/thumb-' . $src, 'uploads/gallery/preview-' . $src]);
            exit('1');
        }
        return;
    }

    public function deleteGalleryTmp()
    {
        $src = isset($_POST['src']) ? $_POST['src'] : null;
        if (!$src) {
            return false;
        }
        \Session::pull('gallery', $src);
        Storage::disk('public')
            ->delete(['uploads/gallery/' . $src, 'uploads/gallery/thumb-' . $src, 'uploads/gallery/preview-' . $src]);
        return 1;
    }
}
