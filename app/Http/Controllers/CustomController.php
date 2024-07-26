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
        $params=['trashed' => 'true'];
        property_exists($this,'queryString') ?
            $params[$this->queryString['params']]=$this->queryString['value'] : '';
        $this->service->delete($modelId);
        return redirect()->route($this->route_params . '.index', $params)->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function removeItems(Request $request)
    {
        $params=['trashed' => 'true'];

        property_exists($this,'queryString') ?
            $params[$this->queryString['params']]=$this->queryString['value'] : '';


        $this->service->removeItems($request);
        return redirect()->route($this->route_params . '.index', $params)->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function restoreItems(Request $request)
    {
        $params=['trashed' => 'true'];
        property_exists($this,'queryString') ?
            $params[$this->queryString['params']]=$this->queryString['value'] : '';
        $this->service->restoreItems($request);
        return redirect()->route($this->route_params . '.index', $params)->with('message', 'عملیات مورد نظر با موفقیت انجام شد.');
    }

    public function restore(int $modelId)
    {
        $params=[];
        property_exists($this,'queryString') ?
            $params[$this->queryString['params']]=$this->queryString['value'] : '';
        $this->service->restore($modelId);
        return redirect()->route($this->route_params . '.index',$params)->with('message', 'عملیات مورد نظر با موفقیت بازیابی شد.');
    }
}
