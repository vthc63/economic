<?php

namespace App\Http\Controllers;

use App\Models\Color;
use App\Models\Setting;
use App\Models\User;
use App\Services\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * @var HomeService
     */
    private $homeService;

    /**
     * HomeController constructor.
     *
     * @param HomeService $homeService
     */
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }
    /**
     * Displays home website.
     *
     * @return \Illuminate\View\View
     */
    public function index() 
    {
        return view('client.index', $this->homeService->index());
    }

    public function maintenance()
    {
        $setting = Setting::first();
        return view('client.maintenance', ['setting' => $setting]);
    }

    public function introduction()
    {
        $setting = Setting::first();
        return view('client.introduction', ['setting' => $setting]);
    }

    public function apiTest()
    {
        $users = User::all();
        return response()->json($users, 200);
    }

    public function apiCreate(Request $request)
    {
        Color::create([
            'name' => $request->color_name
        ]);
        return response()->json(['status-code' => true], 200);
    }
}
