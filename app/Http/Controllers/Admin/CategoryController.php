<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryService
     */
    private $categoryService;

    /**
     * AdminController constructor.
     *
     * @param AdminService $adminService
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return view('admin.category.index', $this->categoryService->index());
    }

    public function create()
    {
        if (count($this->categoryService->create()) > 0) {
            return view('admin.category.create', $this->categoryService->create());
        }

        return redirect()->route('admin.category_index');
    }

    public function store(StoreCategoryRequest $request)
    {
        return $this->categoryService->store($request);
    }

    public function edit(Category $category)
    {
        if (count($this->categoryService->edit($category)) > 0){
            return view('admin.category.edit', $this->categoryService->edit($category));
        }

        return redirect()->route('admin.category_index');
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        return $this->categoryService->update($request, $category);
    }

    public function delete(Request $request)
    {
        return $this->categoryService->delete($request);
    }
}
