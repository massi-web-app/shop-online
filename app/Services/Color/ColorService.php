<?php

namespace App\Services\Color;

use App\Helper\Helper;
use App\Repositories\Color\ColorRepository;
use Illuminate\Http\Request;

class ColorService
{

    private ColorRepository $colorRepository;
    public static int $paginate = 10;

    public function __construct(ColorRepository $colorRepository)
    {

        $this->colorRepository = $colorRepository;
    }


    public function list(Request $request)
    {
        $queryString = '?';
        $colors = $this->colorRepository->list();
        if ($request->get('trashed') == 'true') {
            $colors = $colors->onlyTrashed();
            $queryString = Helper::generateQueryString($queryString, 'trashed=true');
        }

        if (array_key_exists('string', $request->all()) && !empty($request->get('string'))) {
            $colors = $colors->where('title', 'like', '%' . $request->get('string') . '%');
            $queryString = Helper::generateQueryString($queryString, 'string='.$request->get('string'));
        }

        $colors = $colors->paginate(self::$paginate);
        $colors->withPath($queryString);
        return $colors;
    }

    public function countTrashed(): int
    {
        return $this->colorRepository->trashed()->count();
    }

    public function store(array $data)
    {
        return $this->colorRepository->store($data);
    }

    public function update(int $colorId, array $data)
    {
        $color=$this->colorRepository->find($colorId);
        $this->colorRepository->update($color,$data);
    }

    public function removeItems(Request $request)
    {
        $this->colorRepository->remove_items($request->get('color_id'));

    }

    public function restoreItems(Request $request)
    {
        $this->colorRepository->restore_items($request->get('color_id'));
    }


    public function restore(int $colorId)
    {
        $category = $this->colorRepository->withTrashed($colorId);
        $this->colorRepository->restore($category);
        return true;
    }


    public function delete(int $colorId)
    {
        $this->colorRepository->delete($colorId);
    }

}
