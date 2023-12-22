<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSizeRequest;
use App\Models\Size;
use App\Services\SizeService;
use Illuminate\Http\Request;

class SizeController extends Controller
{
    /**
     * @var SizeService
     */
    private $sizeService;

    /**
     * SizeController constructor.
     *
     * @param SizeService $sizeService
     */
    public function __construct(SizeService $sizeService)
    {
        $this->sizeService = $sizeService;
    }
    
    public function index()
    {
        return view('admin.size.index', $this->sizeService->index());
    }

    public function create()
    {
        if (count($this->sizeService->create()) > 0) {
            return view('admin.size.create', $this->sizeService->create());
        }

        return redirect()->route('admin.size_index');
    }

    public function store(StoreSizeRequest $request)
    {
        return $this->sizeService->store($request);
    }

    public function edit(Size $size)
    {
        if (count($this->sizeService->edit($size)) > 0){
            return view('admin.size.edit',$this->sizeService->edit($size));
        }

        return redirect()->route('admin.size_index');
    }

    public function update(StoreSizeRequest $request, Size $size)
    {
        return $this->sizeService->update($request, $size);
    }

    public function delete(Request $request)
    {
        return $this->sizeService->delete($request);
    }
}
