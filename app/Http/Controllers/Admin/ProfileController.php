<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Services\ProfileService;

class ProfileController extends Controller
{
    /**
     * @var ProfileService
     */
    private $profileService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function changeProfile()
    {
        if (count($this->profileService->changeProfile()) > 0){
            return view('admin.profile.change-profile', $this->profileService->changeProfile());
        }

        return redirect()->route('admin.home');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->profileService->updateProfile($request);
    }

    public function changePassword()
    {
        if (count($this->profileService->changePassword()) > 0){
            return view('admin.profile.change-password', $this->profileService->changePassword());
        }

        return redirect()->route('admin.home');
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        return $this->profileService->updatePassword($request);
    }
}
