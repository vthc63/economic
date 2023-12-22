<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    
    public function index()
    {
        return view('admin.user.index', $this->userService->index());
    }

    public function create()
    {
        if (count($this->userService->create()) > 0) {
            return view('admin.user.create', $this->userService->create());
        }

        return redirect()->route('admin.users_index');
    }

    public function store(StoreUserRequest $request)
    {
        return $this->userService->store($request);
    }

    public function edit(User $user)
    {
        if (count($this->userService->edit($user)) > 0){
            return view('admin.user.edit',$this->userService->edit($user));
        }

        return redirect()->route('admin.users_index');
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        return $this->userService->update($request, $user);
    }

    public function delete(Request $request)
    {
        return $this->userService->delete($request);
    }
}
