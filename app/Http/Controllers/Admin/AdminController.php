<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreStaffRequest;
use App\Http\Requests\Admin\UpdateStaffRequest;
use App\Models\User;
use App\Services\AdminService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * @var AdminService
     */
    private $adminService;

    /**
     * AdminController constructor.
     *
     * @param AdminService $adminService
     */
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function index()
    {
        return view('admin.staff.index', $this->adminService->index());
    }

    public function create()
    {
        if (count($this->adminService->create()) > 0) {
            return view('admin.staff.create', $this->adminService->create());
        }

        return redirect()->route('admin.staffs_index');
    }

    public function store(StoreStaffRequest $request)
    {
        return $this->adminService->store($request);
    }

    public function edit(User $user)
    {
        if (count($this->adminService->edit($user)) > 0){
            return view('admin.staff.edit',$this->adminService->edit($user));
        }

        return redirect()->route('admin.staffs_index');
    }

    public function update(UpdateStaffRequest $request, User $user)
    {
        return $this->adminService->update($request, $user);
    }

    public function delete(Request $request)
    {
        return $this->adminService->delete($request);
    }
}
