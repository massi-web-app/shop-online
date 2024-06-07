<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomController;
use App\Http\Requests\Color\ColorRequest;
use App\Repositories\Color\ColorRepository;
use App\Services\Category\Service\CategoryService;
use App\Services\Color\ColorService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ColorController extends CustomController
{


    protected $service;
    protected $title = 'رنگ';
    protected $route_params = 'color';
    private ColorService $colorService;
    private ColorRepository $colorRepository;


    public function __construct(ColorService $colorService,ColorRepository $colorRepository)
    {
        $this->service=$colorService;
        $this->colorService = $colorService;
        $this->colorRepository = $colorRepository;
    }

    public function index(Request $request)
    {
        $colors = $this->colorService->list($request);
        $paginate = ColorService::$paginate;
        $trashed_color_count = $this->colorService->countTrashed();
        return view('color.index', ['colors' => $colors, 'paginate' => $paginate,
            'trashed_color_count' => $trashed_color_count,'request'=>$request]);
    }


    public function create()
    {
        return view('color.create');
    }

    public function store(ColorRequest $request )
    {
        $this->colorService->store($request->all());
        return redirect()->route('color.index')->with('message', 'ثبت برند با موفقیت انجام شد.');

    }


    public function edit(int $colorId): Factory|\Illuminate\Foundation\Application|View|Application
    {
        $color = $this->colorRepository->find($colorId);
        return view('color.edit', ['color' => $color]);
    }

    public function update(int $colorId,ColorRequest $colorRequest)
    {
        $this->colorService->update($colorId,$colorRequest->all());
        return redirect()->route('color.index')->with('message', 'ویرایش رنگ مورد نظر با موفقیت انجام شد.');

    }
}
