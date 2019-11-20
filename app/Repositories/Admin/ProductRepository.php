<?php


namespace App\Repositories\Admin;


use App\Repositories\CoreRepository;
use App\Models\Admin\Product;
use DB;

class ProductRepository extends CoreRepository
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function getModelClass()
    {
        return Product::class;
    }

    public function getProductsByCatId($id, $paginate)
    {
        return $this->startConditions()
            ->where('category_id', $id)
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getLastProducts($paginate)
    {
        return $this->startConditions()
            ->orderBy('id', 'desc')
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getLastAvailableProducts($paginate)
    {
        return $this->startConditions()
            ->where('status', '1')
            ->orderBy('id', 'desc')
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getAllProducts($paginate)
    {
        return $this->startConditions()
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.*', 'categories.title as category')
            //->orderBy('id', 'desc')
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getCountProducts()
    {
        return $this->startConditions()
            ->count();
    }

    public function getProductsByAttrsAndCat($attrs, $paginate, $id)
    {
        return $this->startConditions()
            ->join('attribute_products', 'attribute_products.product_id', '=', 'products.id')
            ->select('products.*')
            ->where('products.category_id', '=', $id)
            ->wherein('attribute_products.attr_id', $attrs)
            ->sortable()
            ->limit($paginate)
            ->paginate($paginate);
//        return $this->startConditions()
//            ->join('attribute_products','products.id','=','attribute_products.product_id')
//            ->select('products.*')
//            ->where(function ($query,$attrs,$id){
//                $query->where('products.category_id','=',$id)
//                    ->whereIn('products.id',$attrs);
//            })
//            ->limit($paginate)
//            ->paginate($paginate);
//        return $this->startConditions()
//            ->join('attribute_products','products.id','=','attribute_products.product_id')
//            ->select('products.*')
//            ->whereIn('products.id',$attrs)
//            ->limit($paginate)
//            ->paginate($paginate);
    }

    public function getProducts($q)
    {
        return DB::table('products')
            ->select('id', 'title')
            ->where('title', 'LIKE', ["%{$q}%"])
            ->limit(8)
            ->get();
    }

    public function uploadImg($filename, $wmax, $hmax)
    {
        $uplad_dir = 'uploads/single/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $filename));
        $uploadfile = $uplad_dir . $filename;
        \Session::put('single', $filename);
        self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
    }

    public function uploadGallery($filename, $wmax, $hmax, $thumb_wmax, $thumb_hmax, $preview_wmax, $preview_hmax)
    {
        $uplad_dir = 'uploads/gallery/';
        $ext = strtolower(preg_replace("#.+\.([a-z]+)$#i", "$1", $_FILES[$filename]['name']));
        $new_name = md5(time()) . ".$ext";
        $new_name_thumb = 'thumb-' . md5(time()) . ".$ext";
        $new_name_preview = 'preview-' . md5(time()) . ".$ext";
        $uploadfile = $uplad_dir . $new_name;
        $uploadfile_thumb = $uplad_dir . $new_name_thumb;
        $uploadfile_thumb_preview = $uplad_dir . $new_name_preview;
        \Session::push('gallery', $new_name);
        if (@move_uploaded_file($_FILES[$filename]['tmp_name'], $uploadfile)) {
            self::resize($uploadfile, $uploadfile, $wmax, $hmax, $ext);
            self::resize($uploadfile, $uploadfile_thumb, $thumb_wmax, $thumb_hmax, $ext);
            self::resize($uploadfile, $uploadfile_thumb_preview, $preview_wmax, $preview_hmax, $ext);
            $res = array("file" => $new_name);
            echo json_encode($res);
        }
    }

    public function getImg(Product $product)
    {
        clearstatcache();
        if (!empty(\Session::get('single'))) {
            $name = \Session::get('single');
            $product->img = $name;
            \Session::forget('single');
            return;
        }
        if (empty(\Session::get('single')) && !is_file(WWW . '/uploads/single/' . $product->img)) {
            $product->img = null;
        }
        return;
    }

    public function editFilter($id, $data)
    {
        $filter = DB::table('attribute_products')
            ->where('product_id', '=', $id)
            ->pluck('attr_id')
            ->toArray();
//        If Reset Filters
        if (empty($data['attrs']) && !empty($filter)) {
            DB::table('attribute_products')
                ->where('product_id', '=', $id)
                ->delete();
            return;
        }
//        If added Filters
        if (!empty($data['attrs']) && empty($filter)) {
            $sql_part = '';
            foreach ($data['attrs'] as $val) {
                $sql_part .= "($val, $id),";
            }
            $sql_part = rtrim($sql_part, ',');
            DB::insert("insert into attribute_products (attr_id, product_id) values $sql_part");
            return;
        }
//        Change Filters
        if (!empty($data['attrs'])) {
            $res = array_diff($data['attrs'], $filter);
            if ($res) {
                DB::table('attribute_products')
                    ->where('product_id', '=', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['attrs'] as $val) {
                    $sql_part .= "($val, $id),";
                }
                $sql_part = rtrim($sql_part, ',');
                DB::insert("insert into attribute_products (attr_id, product_id) values $sql_part");
                return;
            }
        }
    }

    public function editRelatedProduct($id, $data)
    {
        $related_product = DB::table('related_products')
            ->select('related_id')
            ->where('product_id', '=', $id)
            ->pluck('related_id')
            ->toArray();
//        Reset related
        if (empty($data['related']) && !empty($related_product)) {
            DB::table('related_product')
                ->where('product_id', '=', $id)
                ->delete();
            return;
        }
//        Add related
        if (empty($related_product) && !empty($data['related'])) {
            $sql_part = '';
            foreach ($data['related'] as $val) {
                $val = (int)$val;
                $sql_part .= "($id, $val),";
                $sql_part = rtrim($sql_part, ',');
                DB::insert("insert into related_products (product_id, related_id) VALUES $sql_part");
                return;
            }
        }
//        If changed related
        if (!empty($data['related'])) {
            $res = array_diff($related_product, $data['related']);
            if (!(empty($res)) || count($related_product) != count($data['related'])) {
                DB::table('related_products')
                    ->where('product_id', '=', $id)
                    ->delete();
                $sql_part = '';
                foreach ($data['related'] as $val) {
                    $sql_part .= "($id, $val),";
                }
                $sql_part = rtrim($sql_part, ',');
                DB::insert("insert into related_products (product_id, related_id) values $sql_part");
            }
        }
    }

    public function saveGallery($id)
    {
        if (!empty(\Session::get('gallery'))) {
            $sql_part = '';
            foreach (\Session::get('gallery') as $val) {
                $sql_part .= "($id, '$val'),";
            }
            $sql_part = rtrim($sql_part, ',');
            DB::insert("insert into galleries (product_id, img) values $sql_part");
            \Session::forget('gallery');
        }
    }

    public function getInfoProduct($id)
    {
        return $this->startConditions()
            ->find($id);
    }

    public function getProductByAlias($alias)
    {
        return $this->startConditions()
            ->where('alias','=', $alias)
            ->first();
    }

    public function getFiltersProduct($id)
    {
        return DB::table('attribute_products')
            ->select('attr_id')
            ->where('product_id', $id)
            ->pluck('attr_id')
            ->all();
    }

    public function getFiltersProductRaw($id)
    {
        return DB::table('attribute_products')
            ->select('attribute_products.*')
            ->where('product_id', $id)
            ->get();
    }

    public function getRelatedProducts($id)
    {
        return $this->startConditions()
            ->join('related_products', 'products.id', '=', 'related_products.related_id')
            ->select('products.title', 'related_products.related_id')
            ->where('related_products.product_id', $id)
            ->get();
    }

    public function getRelatedProductsList($id, $lim)
    {
        return $this->startConditions()
            ->join('related_products', 'products.id', '=', 'related_products.related_id')
            ->select('products.*')
            ->where('related_products.product_id', $id)
            ->limit($lim)
            ->get();
    }

    public function getGallery($id)
    {
        return DB::table('galleries')
            ->where('product_id', $id)
            ->pluck('img')
            ->all();
    }

    public function getStatusOne($id)
    {
        if (isset($id)) {
            $status = DB::update("UPDATE products SET status = '1' WHERE id = ?", [$id]);
            if ($status) {
                return true;
            } else return false;
        }
    }

    public function deleteStatusOne($id)
    {
        if (isset($id)) {
            $status = DB::update("UPDATE products SET status = '0' WHERE id = ?", [$id]);
            if ($status) {
                return true;
            } else return false;
        }
    }

    public function deleteImgGalleryFromPath($id)
    {
        if (isset($id)) {
            $gallery = DB::table('galleries')
                ->select('img')
                ->where('product_id', '=', $id)
                ->pluck('img')
                ->all();
            $singleImg = DB::table('products')
                ->select('img')
                ->where('id', '=', $id)
                ->pluck('img')
                ->all();
            if (!empty($gallery)) {
                foreach ($gallery as $img) {
                    @unlink("uploads/gallery/$img");
                    @unlink("uploads/gallery/thumb-$img");
                    @unlink("uploads/gallery/preview-$img");
                }
            }
            if (!empty($singleImg)) {
                @unlink("uploads/single/" . $singleImg[0]);
            }
        }
    }

    public function deleteFromDB($id)
    {
        if (isset($id)) {
            DB::delete('DELETE FROM related_products WHERE product_id = ?', [$id]);
            DB::delete('DELETE FROM attribute_products WHERE product_id = ?', [$id]);
            DB::delete('DELETE FROM galleries WHERE product_id = ?', [$id]);
            return DB::delete('DELETE FROM products WHERE id = ?', [$id]);
        }
    }

    public function getSearchResult($query, $paginate)
    {
        return $this->startConditions()
            ->where([['title', 'LIKE', '%' . $query . '%'], ['status', '=', '1'],])
            ->limit($paginate)
            ->paginate($paginate);
    }

    public function getAutocompleteByTerms($term)
    {
        return $this->startConditions()
            ->select('title')
            ->where('title', 'LIKE', '%' . $term . '%')
            ->pluck('title');
    }

    public function getCategoryByIdWithFilters($id, $paginate)
    {
        return $this->startConditions()
            ->join('attribute_products', 'products.id', '=', 'attribute_products.attr_id')
            ->where('category_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit($paginate)
            ->paginate($paginate);

    }

    public function delImgIfExist($filename)
    {
        $this->startConditions()
            ->where('img', $filename)
            ->update(['img' => '']);
    }

//Others Function

//Image Resize
    public static function resize($target, $dist, $widthMax, $heightMax, $expansion)
    {
        list($width_original, $height_original) = getimagesize($target);

        // $ratio = 1 — square, < 1 — vertic, > 1 — horiz
        $ratio = $width_original / $height_original;

        if (($widthMax / $heightMax) > $ratio) {
            $widthMax = $heightMax * $ratio;
        } else {
            $heightMax = $widthMax / $ratio;
        }
        $img = "";
        switch ($expansion) {
            case("gif") :
                $img = imagecreatefromgif($target);
                break;
            case("png") :
                $img = imagecreatefrompng($target);
                break;
            default:
                $img = imagecreatefromjpeg($target);
        }

        $newImg = imagecreatetruecolor($widthMax, $heightMax);

        if ($expansion == "png") {
            imagesavealpha($newImg, true); // Сохранение альфа-канала

            // Прозрачность для полотна
            $transPng = imagecolorallocatealpha($newImg, 0, 0, 0, 127);

            imagefill($newImg, 0, 0, $transPng); // заливка
        }

        imagecopyresampled($newImg, $img, 0, 0, 0, 0, $widthMax, $heightMax, $width_original, $height_original); // копируем и ресайзим изображение

        switch ($expansion) {
            case("gif"):
                imagegif($newImg, $dist);
                break;
            case("png"):
                imagepng($newImg, $dist);
                break;
            default:
                imagejpeg($newImg, $dist);
        }

        imagedestroy($newImg);
    }
}