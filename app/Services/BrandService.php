<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\Admin\StoreCommonRequest;
use App\Models\Brand;
use App\Repository\Eloquent\BrandRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BrandService 
{
    /**
     * @var BrandRepository
     */
    private $brandRepository;

    /**
     * BrandService constructor.
     *
     * @param BrandRepository $brandRepository
     */
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get list brand
        $list = $this->brandRepository->all();
        $tableCrud = [
            'headers' => [
                [
                    'text' => 'Mã TH',
                    'key' => 'id',
                ],
                [
                    'text' => 'Tên Thương Hiệu',
                    'key' => 'name',
                ],
            ],
            'actions' => [
                'text'          => "Thao Tác",
                'create'        => true,
                'createExcel'   => false,
                'edit'          => true,
                'deleteAll'     => true,
                'delete'        => true,
                'viewDetail'    => false,
            ],
            'routes' => [
                'create' => 'admin.brands_create',
                'delete' => 'admin.brands_delete',
                'edit' => 'admin.brands_edit',
            ],
            'list' => $list,
        ];

        return [
            'title' => TextLayoutTitle("brand"),
            'tableCrud' => $tableCrud,
        ];
    }

    /**
     * Show the form for creating a new user.
     *
     * @return array
     */
    public function create()
    {
        try {
            // Fields form
            $fields = [
                [
                    'attribute' => 'name',
                    'label' => 'Tên Thương Hiệu',
                    'type' => 'text',
                ],
            ];
    
            //Rules form
            $rules = [
                'name' => [
                    'required' => true,
                    'minlength' => 1,
                    'maxlength' => 100,
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'name' => [
                    'required' => __('message.required', ['attribute' => 'Tên danh mục']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Tên danh mục']),
                    'maxlength' => __('message.max', ['max' => 100, 'attribute' => 'Tên danh mục']),
                ],
            ];
    
            return [
                'title' => TextLayoutTitle("create_brand"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
            ];
        } catch (Exception) {
            return [];
        }
        
    }

    /** 
     * store the admin in the database.
     * @param App\Http\Requests\Admin\StoreCategoryRequest $request
     * @return Illuminate\Http\RedirectResponse
     */
    public function store(StoreCommonRequest $request)
    {
        try {
            $data = $request->validated();
            $this->brandRepository->create($data);
            return redirect()->route('admin.brands_index')->with('success', TextSystemConst::CREATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('admin.brands_index')->with('error', TextSystemConst::CREATE_FAILED);
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return array
     */
    public function edit(Brand $category)
    {
        try {
            // Fields form
            $fields = [
                [
                    'attribute' => 'name',
                    'label' => 'Tên Thương Hiệu',
                    'type' => 'text',
                    'value' => $category->name,
                ],
            ];
    
            //Rules form
            $rules = [
                'name' => [
                    'required' => true,
                    'minlength' => 1,
                    'maxlength' => 100,
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'name' => [
                    'required' => __('message.required', ['attribute' => 'Tên danh mục']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Tên danh mục']),
                    'maxlength' => __('message.max', ['max' => 100, 'attribute' => 'Tên danh mục']),
                ],
            ];
    
            return [
                'title' => TextLayoutTitle("edit_brand"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
                'category' => $category,
            ];
        } catch (Exception) {
            return [];
        }
        
    }

    public function update(StoreCommonRequest $request, Brand $color)
    {
        try {
            $data = $request->validated();
            $this->brandRepository->update($color, $data);
            return redirect()->route('admin.brands_index')->with('success', TextSystemConst::UPDATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->route('admin.brands_index')->with('error', TextSystemConst::UPDATE_FAILED);
        }
    }

     /** 
     * delete the user in the database.
     * @param Illuminate\Http\Request; $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        try{
            if($this->brandRepository->delete($this->brandRepository->find($request->id))) {
                return response()->json(['status' => 'success', 'message' => TextSystemConst::DELETE_SUCCESS], 200);
            }

            return response()->json(['status' => 'failed', 'message' => TextSystemConst::DELETE_FAILED], 200);
        } catch (Exception $e) {
            Log::error($e);
            return response()->json(['status' => 'error', 'message' => TextSystemConst::SYSTEM_ERROR], 200);
        }
    }
}
?>