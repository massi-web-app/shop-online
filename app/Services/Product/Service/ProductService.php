<?php

namespace App\Services\Product\Service;

use App\Helper\Helper;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use App\Repositories\Product\ProductRepository;
use App\Services\Category\Service\CategoryService;
use App\Services\Category\Service\ItemService;
use App\Services\Uploader\Uploader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductService
{

    private Uploader $uploader;
    private ProductRepository $productRepository;
    public static int $paginate = 10;
    private CategoryService $categoryService;
    private ItemService $itemService;


    public function __construct(Uploader $uploader, ProductRepository $productRepository, CategoryService $categoryService, ItemService $itemService)
    {

        $this->uploader = $uploader;
        $this->productRepository = $productRepository;
        $this->categoryService = $categoryService;
        $this->itemService = $itemService;
    }

    public function list(Request $request)
    {
        $queryString = '?';
        $products = $this->productRepository->list();
        if (Helper::isTrashed($request)) {
            $products = $products->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (Helper::hasStringInSearch($request)) {
            $products = $products->where('title', 'like', '%' . $request->get('string') . '%');
            $products = $products->orWhere('ename', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string=' . $request->get('string'));
        }

        $products = $products->paginate(self::$paginate);
        $products->withPath($queryString);
        return $products;

    }

    public function getStatusProduct(): array
    {
        return $this->productRepository->getStatus();
    }

    public function store(ProductRequest $request)
    {
        try {
            $data = $request->all();
            $image = $this->uploader->upload($request->file('image_url'), 'files/products');
            if (!empty($image)) {
                $data['image_url'] = $image;
                //todo:resolve thumbnails
            }
            $product = $this->productRepository->store($data);
            $this->productRepository->updateProductColors($product, $request->get('product_color_id'));
            return $product;
        } catch (\Exception $exception) {
            return false;
        }
    }

    public function countTrashed(): int
    {
        return $this->productRepository->trashed()->count();
    }

    public function listStatus()
    {
        return $this->productRepository->getStatus();
    }

    public function find(int $productId)
    {
        return $this->productRepository->find($productId);
    }

    public function update(ProductRequest $request, int $productId)
    {
        $product = $this->find($productId);
        $image_url = $this->uploader->upload($request->file('image_url'), 'files/products');
        if (!empty($image_url)) {
            $this->uploader->removeFile('files/products', $product->image_url);
            $product->image_url = $image_url;
            $product->save();
        }
        $this->productRepository->update($product, $request->except(['image_url']));
        $this->productRepository->updateProductColors($product, $request->get('product_color_id'));
        return $product;
    }

    public function delete(int $productId)
    {
        return $this->productRepository->delete($productId);
    }

    public function restore(int $productId)
    {
        $this->productRepository->restore($productId);
    }

    public function removeItems($request)
    {
        $this->productRepository->remove_items($request->get('product_id'));
    }

    public function restoreItems($request)
    {
        $this->productRepository->restore_items($request->get('product_id'));
    }

    public function uploadGallery(int $productId, Request $request)
    {
        $product = $this->productRepository->find($productId);

        if ($product) {
            $count = DB::table('product_galleries')
                ->where('product_id', $productId)
                ->count();
            $image_url = $this->uploader->upload($request->file('file'), 'files/gallery', 'image_' . $productId . rand(1, 100));

            if (!empty($image_url)) {
                $count++;
                DB::table('product_galleries')
                    ->insert([
                        'product_id' => $productId,
                        'image_url' => $image_url,
                        'position' => $count
                    ]);
                return 1;
            }
            return 0;
        }
        return 0;

    }

    public function listGalleries(int $productId): Collection|array
    {
        return $this->productRepository->listGalleries($productId);

    }

    public function removeGalleryFromGallery(int $imageId): bool
    {
        try {
            $image = $this->productRepository->findGallery($imageId);
            $image_url = $image->image_url;
            $image->delete();
            $this->uploader->removeFile('files/gallery', $image_url);
            return true;
        } catch (\Exception $exception) {
            dd($exception);
            return false;
        }

    }

    public function sortGallery(array $parameters): string
    {
        $position = 1;
        foreach ($parameters as $key => $parameter) {
            if (!empty($parameter)) {
                DB::table('product_galleries')->where('id', $parameter)->update(['position' => $position]);
                $position++;
            }
        }
        return 'ok';
    }

    public function getItems(Product|Collection $product): Collection|array
    {
        define('product_id',$product->id);
        $category = $this->categoryService->find($product->category_id);
        $category_ids[0] = $product->category_id;
        if ($category) {
            $category_ids[1] = $category->parent_id;
        }
        return $this->itemService->getItemProduct($category_ids);
    }

    public function add_items(Model|Collection|Builder|array|null $product, array $data)
    {
        $this->itemService->clear_value_items($product);
        foreach ($data as $item_id=>$value){
            foreach ($value as $key2=>$item_value){
                if (!empty($item_value)){
                    $this->itemService->add_item_value_to_product($product,$item_id,$item_value);
                }
            }
        }


    }


}
