<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\Admin\StoreSizeRequest;
use App\Models\Color;
use App\Models\ProductType;
use App\Models\Size;
use App\Repository\Eloquent\ProductTypeRepository;
use App\Repository\Eloquent\SizeRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SizeService 
{
    /**
     * @var SizeRepository
     */
    private $sizeRepository;

    /**
     * SizeService constructor.
     *
     * @param SizeRepository $sizeRepository
     * @param ProductTypeRepository $productTypeRepository
     */
    public function __construct(SizeRepository $sizeRepository)
    {
        $this->sizeRepository = $sizeRepository;
    }

    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get list colors
        $list = $this->sizeRepository->all();
        $tableCrud = [
            'headers' => [
                [
                    'text' => 'Mã Kích Thước',
                    'key' => 'id',
                ],
                [
                    'text' => 'Tên Kích Thước',
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
                'create' => 'admin.sizes_create',
                'delete' => 'admin.sizes_delete',
                'edit' => 'admin.sizes_edit',
            ],
            'list' => $list,
        ];

        return [
            'title' => TextLayoutTitle("size"),
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
                    'label' => 'Tên Kích Thước',
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
                    'required' => __('message.required', ['attribute' => 'Tên kích thước']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Tên kích thước']),
                    'maxlength' => __('message.max', ['max' => 100, 'attribute' => 'Tên kích thước']),
                ],
            ];
    
            return [
                'title' => TextLayoutTitle("create_size"),
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
    public function store(StoreSizeRequest $request)
    {
        try {
            $data = $request->validated();
            $this->sizeRepository->create($data);
            return redirect()->route('admin.sizes_index')->with('success', TextSystemConst::CREATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('admin.sizes_index')->with('error', TextSystemConst::CREATE_FAILED);
        }
    }

    /**
     * Show the form for creating a new user.
     *
     * @return array
     */
    public function edit(Size $size)
    {
        try {
            // Fields form
            $fields = [
                [
                    'attribute' => 'name',
                    'label' => 'Tên Kích Thước',
                    'type' => 'text',
                    'value' => $size->name,
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
                    'required' => __('message.required', ['attribute' => 'Tên kích thước']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Tên kích thước']),
                    'maxlength' => __('message.max', ['max' => 100, 'attribute' => 'Tên kích thước']),
                ],
            ];
    
            return [
                'title' => TextLayoutTitle("edit_size"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
                'size' => $size,
            ];
        } catch (Exception) {
            return [];
        }
        
    }

    public function update(StoreSizeRequest $request, Size $size)
    {
        try {
            $data = $request->validated();
            $this->sizeRepository->update($size, $data);
            return redirect()->route('admin.sizes_index')->with('success', TextSystemConst::UPDATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            return redirect()->route('admin.sizes_index')->with('error', TextSystemConst::UPDATE_FAILED);
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
            if($this->sizeRepository->delete($this->sizeRepository->find($request->id))) {
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