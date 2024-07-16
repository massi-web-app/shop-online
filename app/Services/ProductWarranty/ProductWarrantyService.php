<?php

namespace App\Services\ProductWarranty;

use App\Http\Requests\ProductWarranty\ProductWarrantyRequest;
use App\Models\ProductColor;
use App\Repositories\ProductColor\ProductColorRepository;
use App\Repositories\ProductWarranty\ProductWarrantyRepository;
use App\Repositories\Warranty\WarrantyRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProductWarrantyService
{
    private WarrantyRepository $warrantyRepository;
    private ProductColorRepository $productColorRepository;
    private ProductWarrantyRepository $productWarrantyRepository;

    public function __construct(ProductWarrantyRepository $productWarrantyRepository,WarrantyRepository $warrantyRepository,ProductColorRepository $productColorRepository)
    {
        $this->warrantyRepository = $warrantyRepository;
        $this->productColorRepository = $productColorRepository;
        $this->productWarrantyRepository = $productWarrantyRepository;
    }

    public function listWarranties(): array
    {
        return $this->warrantyRepository->list()->orderBy('id','desc')->pluck('name','id')->toArray();
    }

    public function listProductColor(int $productId): Collection
    {
        return $this->productColorRepository->listProductColor($productId);

    }

    public function save(ProductWarrantyRequest $productWarrantyRequest): Model|ProductColor
    {
        return $this->productWarrantyRepository->save($productWarrantyRequest->all());

    }
}
