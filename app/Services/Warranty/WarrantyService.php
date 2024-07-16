<?php

namespace App\Services\Warranty;

use App\Helper\Helper;
use App\Http\Requests\Warranty\WarrantyRequest;
use App\Repositories\Warranty\WarrantyRepository;
use Illuminate\Http\Request;

class WarrantyService
{
    private WarrantyRepository $warrantyRepository;
    public static int $paginate = 10;

    public function __construct(WarrantyRepository $warrantyRepository)
    {
        $this->warrantyRepository = $warrantyRepository;
    }

    public function list(Request $request)
    {
        $queryString = '?';
        $warranties = $this->warrantyRepository->list();
        if ($request->get('trashed') == 'true') {
            $warranties = $warranties->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (array_key_exists('string', $request->all()) && !empty($request->get('string'))) {
            $warranties = $warranties->where('name', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string=' . $request->get('string'));
        }

        $warranties = $warranties->paginate(self::$paginate);
        $warranties->withPath($queryString);
        return $warranties;
    }

    public function countTrashed()
    {
        return $this->warrantyRepository->trashed()->count();
    }

    public function store(WarrantyRequest $request)
    {
        return $this->warrantyRepository->store($request->all());
    }

    public function find(int $warrantyId)
    {
        return $this->warrantyRepository->find($warrantyId);
    }

    public function update(WarrantyRequest $request,int $warrantyId)
    {
        $warranty=$this->warrantyRepository->find($warrantyId);
        return $this->warrantyRepository->update($warranty,$request->all());
    }

    public function removeItems(Request $request)
    {
        $this->warrantyRepository->remove_items($request->get('warranty_id'));
    }

    public function restoreItems(Request $request)
    {
        $this->warrantyRepository->restore_items($request->get('warranty_id'));
    }

    public function delete(int $warrantyId)
    {
        return $this->warrantyRepository->delete($warrantyId);
    }

    public function restore(int $warrantyId)
    {
        $warranty=$this->warrantyRepository->withTrashed($warrantyId);
        return $this->warrantyRepository->restore($warranty);
    }
}
