<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class CustomController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function destroy(int $modelId): RedirectResponse
    {
        $this->service->delete($modelId);
        return redirect()->route($this->route_params.'.index',['trashed'=>'true'])->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function removeItems(Request $request)
    {
        $this->service->removeItems($request);
        return redirect()->route($this->route_params.'.index',['trashed'=>'true'])->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function restoreItems(Request $request)
    {
        $this->service->restoreItems($request);
        return redirect()->route($this->route_params.'.index',['trashed'=>'true'])->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function restore(int $categoryId)
    {
        $this->service->restore($categoryId);
        return redirect()->route($this->route_params.'.index')->with('message', 'دسته مورد نظر با موفقیت بازیابی شد.');
    }
}
