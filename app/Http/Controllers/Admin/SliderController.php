<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\CustomController;
use App\Http\Requests\Slider\SliderRequest;
use App\Services\Slider\SliderService;
use Illuminate\Http\Request;

class SliderController extends CustomController
{

    protected $service;
    protected $title = 'اسلایدر';
    protected $route_params = 'sliders';
    private SliderService $sliderService;

    public function __construct(SliderService $sliderService)
    {
        $this->service = $sliderService;
        $this->sliderService = $sliderService;
    }

    public function index(Request $request)
    {
        $sliders = $this->sliderService->list($request);
        $sliders_trashed_count = $this->sliderService->trashed_count();
        $paginate=SliderService::$paginate;

        return view('slider.index', ['sliders' => $sliders, 'request' => $request, 'sliders_trashed_count' => $sliders_trashed_count,'paginate'=>$paginate]);

    }

    public function create()
    {
        return view('slider.create');

    }

    public function store(SliderRequest $request)
    {
        $this->sliderService->store($request);
        return redirect()->route('sliders.index')->with('message', 'ثبت اسلایدر با موفقیت انجام شد');
    }

    public function edit(int $sliderId)
    {
        $slider = $this->sliderService->find($sliderId);

        return view('slider.edit', ['slider' => $slider]);
    }

    public function update(int $sliderId, SliderRequest $sliderRequest)
    {
        $this->sliderService->update($sliderId, $sliderRequest);
        return redirect()->route('sliders.index')->with('message', 'ویرایش اسلایدر با موفقیت انجام شد.');

    }
}
