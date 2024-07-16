<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use App\Http\Requests\Warranty\WarrantyRequest;
use App\Services\Brand\Service\BrandService;
use App\Services\Warranty\WarrantyService;
use Illuminate\Http\Request;

class WarrantyController extends CustomController
{
    private WarrantyService $warrantyService;
    protected $service;
    protected $title = 'گارانتی';
    protected $route_params = 'warranty';

    public function __construct(WarrantyService $warrantyService)
    {
        $this->warrantyService = $warrantyService;
        $this->service = $warrantyService;
    }

    public function index(Request $request)
    {
        $warranties = $this->warrantyService->list($request);
        $paginate = WarrantyService::$paginate;
        $trashed_warranty_count = $this->warrantyService->countTrashed();
        return view('warranty.index', ['warranties' => $warranties,'paginate'=>$paginate,'trashed_warranty_count'=>$trashed_warranty_count,'request'=>$request]);
    }

    public function create()
    {
        return view('warranty.create');
    }

    public function store(WarrantyRequest $request)
    {
        $this->warrantyService->store($request);
        return redirect()->route('warranty.index')->with('message', 'ثبت برند با موفقیت انجام شد.');
    }

    public function edit(int $warrantyId)
    {
         $warranty=$this->warrantyService->find($warrantyId);
         return view('warranty.edit',['warranty'=>$warranty]);
    }

    public function update(WarrantyRequest $request,int $warrantyId)
    {
        $this->warrantyService->update($request,$warrantyId);
        return redirect()->route('warranty.index')->with('message', 'ویرایش گارانتی با موفقیت انجام شد.');
    }
}
