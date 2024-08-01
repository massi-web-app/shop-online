<?php

namespace App\Services\Slider;

use App\Helper\Helper;
use App\Http\Requests\Slider\SliderRequest;
use App\Models\Slider;
use App\Repositories\Slider\SliderRepository;
use App\Services\Uploader\Uploader;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class SliderService
{
    private SliderRepository $sliderRepository;
    private Uploader $uploader;
    public static int $paginate = 10;

    public function __construct(SliderRepository $sliderRepository, Uploader $uploader)
    {

        $this->sliderRepository = $sliderRepository;
        $this->uploader = $uploader;
    }

    public function list(Request $request)
    {
        $queryString = '?';
        $sliders = $this->sliderRepository->list();
        if (Helper::isTrashed($request)) {
            $sliders = $sliders->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        $sliders = $sliders->paginate(self::$paginate);
        $sliders->withPath($queryString);
        return $sliders;

    }


    public function store(SliderRequest $request)
    {
        $data = $request->all();
        $image_url = $this->uploader->upload($request->file('image_url'), 'files/slider', 'desktop_');
        $mobile_image_url = $this->uploader->upload($request->file('mobile_image_url'), 'files/slider', 'mobile_');
        $data['image_url'] = $image_url;
        $data['mobile_image_url'] = $mobile_image_url;
        $this->sliderRepository->store($data);

    }

    public function find(int $sliderId): Model|Slider
    {
        return $this->sliderRepository->find($sliderId);

    }

    public function update(int $sliderId, SliderRequest $request)
    {
        $slider=$this->find($sliderId);
        $old_image_url=$slider->image_url;
        $old_mobile_image_url=$slider->mobile_image_url;
        $data = $request->all();

        $image_url = $this->uploader->upload($request->file('image_url'), 'files/slider', 'desktop_');
        $mobile_image_url = $this->uploader->upload($request->file('mobile_image_url'), 'files/slider', 'mobile_');


        if ($image_url!==null){
            $data['image_url'] = $image_url;
            Helper::removeFile('files/slider',$old_image_url);

        }
        if ($mobile_image_url!==null){
            $data['mobile_image_url'] = $mobile_image_url;
            if (!empty($mobile_image_url)){
                Helper::removeFile('files/slider',$old_mobile_image_url);
            }

        }
        $this->sliderRepository->update($slider,$data);

    }

    public function trashed_count():int
    {
        return $this->sliderRepository->trashed()->count();
    }

    public function removeItems(Request $request)
    {
        $this->sliderRepository->remove_items($request->get('slider_id'));
    }

    public function restoreItems(Request $request)
    {
        $this->sliderRepository->restore_items($request->get('slider_id'));
    }

    public function restore(int $categoryId)
    {
        $slider = $this->sliderRepository->withTrashed($categoryId);
        $this->sliderRepository->restore($slider);
        return true;
    }

    public function delete(int $sliderId)
    {
        $this->sliderRepository->delete($sliderId);
    }


}
