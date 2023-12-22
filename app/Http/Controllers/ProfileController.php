<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileUserService;

class ProfileController extends Controller
{
    /**
     * @var ProfileUserService
     */
    private $profileUserService;

    /**
     * ProfileController constructor.
     *
     * @param ProfileUserService $profileUserService
     */
    public function __construct(ProfileUserService $profileUserService)
    {
        $this->profileUserService = $profileUserService;
    }
    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        return view('client.profile', $this->profileUserService->index());
    }

    public function changeProfile(UpdateProfileRequest $request)
    {
        return $this->profileUserService->changeProfile($request);
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        return $this->profileUserService->changePassword($request);
    }
}
