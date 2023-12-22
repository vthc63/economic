<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCommonRequest;
use App\Models\Color;
use App\Services\ColorService;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * @var ColorService
     */
    private $colorService;

    /**
     * AdminController constructor.
     *
     * @param ColorService $adminService
     */
    public function __construct(ColorService $colorService)
    {
        $this->colorService = $colorService;
    }
    
    public function index()
    {
        return view('admin.color.index', $this->colorService->index());
    }

    public function create()
    {
        if (count($this->colorService->create()) > 0) {
            return view('admin.color.create', $this->colorService->create());
        }

        return redirect()->route('admin.colors_index');
    }

    public function store(StoreCommonRequest $request)
    {
        return $this->colorService->store($request);
    }

    public function edit(Color $color)
    {
        if (count($this->colorService->edit($color)) > 0){
            return view('admin.color.edit',$this->colorService->edit($color));
        }

        return redirect()->route('admin.colors_index');
    }

    public function update(StoreCommonRequest $request, Color $color)
    {
        return $this->colorService->update($request, $color);
    }

    public function delete(Request $request)
    {
        return $this->colorService->delete($request);
    }
}
