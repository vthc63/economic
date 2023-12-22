<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\ChangePasswordRequest as RequestsChangePasswordRequest;
use App\Http\Requests\UpdateProfileRequest as RequestsUpdateProfileRequest;
use App\Models\UserVerify;
use App\Notifications\VerifyUserRegister;
use App\Repository\Eloquent\AddressRepository;
use App\Repository\Eloquent\UserRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ProfileUserService 
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var AddressRepository
     */
    private $addressRepository;

    /**
     * ProfileService constructor.
     *
     * @param UserRepository $userRepository
     * @param AddressRepository $addressRepository
     */
    public function __construct(UserRepository $userRepository, AddressRepository $addressRepository)
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
    }

    public function index()
    {
        $city = old('city') ?? Auth::user()->address->city;
        $district = old('district') ?? Auth::user()->address->district;
        $ward = old('ward') ?? Auth::user()->address->ward;
        $apartment_number = old('apartment_number') ?? Auth::user()->address->apartment_number;
        $phoneNumber = old('phone_number') ?? Auth::user()->phone_number;
        $fullName = old('full_name') ?? Auth::user()->name;
        $email = old('email') ?? Auth::user()->email;
        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/province');
        $citys = json_decode($response->body(), true);
        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/district', [
            'province_id' => $city,
        ]);
        $districts = json_decode($response->body(), true);
        $response = Http::withHeaders([
            'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
        ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/ward', [
            'district_id' => $district,
        ]);
        $wards = json_decode($response->body(), true);
        return [
            'citys' => $citys['data'],
            'districts' => $districts['data'],
            'wards' => $wards['data'],
            'city' => $city,
            'district' => $district,
            'ward' => $ward,
            'apartment_number' => $apartment_number,
            'phoneNumber' => $phoneNumber,
            'email' => $email,
            'fullName' => $fullName,
        ];
    }
    
    public function changePassword(RequestsChangePasswordRequest $request)
    {
        try {
            $request->validated();
            $data = [
                'password' => $request->new_password,
                'updated_by' => Auth::user()->id,
            ];
            $user = $this->userRepository->find(Auth::user()->id);
            $this->userRepository->update($user, $data);
            return back()->with('success', TextSystemConst::CHANGE_PASSWORD['success']);
        } catch (Exception) {
            return back()->with('error', TextSystemConst::CHANGE_PASSWORD['error']);
        }
    }

    public function changeProfile(RequestsUpdateProfileRequest $request)
    {
        try {
            $user = $this->userRepository->find(Auth::user()->id);
            $data = $request->validated();
            // user data request
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'role_id' => $user->role_id,
                'updated_by' => Auth::user()->id,
            ];
            // address data request
            $addressData = [
                'city' => $data['city'],
                'district' => $data['district'],
                'ward' => $data['ward'],
                'apartment_number' => $data['apartment_number'],
            ];
            $addressData['user_id'] = $user->id;
            $this->addressRepository->update($user->address, $addressData);

            DB::beginTransaction();
            if ($userData['email'] !== $user->email) {
                unset($userData['email']);
                $this->userRepository->update($user, $userData);
                $token = Str::random(64);
                $time = Config::get('auth.verification.expire.resend', 60);
                UserVerify::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'token' => $token,
                        'expires_at' => Carbon::now()->addMinutes($time),
                        'email_verify' => $request->email,
                    ]
                );
                $user['email'] = $request->email;
                $user->notify(new VerifyUserRegister($token));
            } else {
                $this->userRepository->update($user, $userData);
            }
            DB::commit();
            return back()->with('success', TextSystemConst::UPDATE_SUCCESS);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return back()->with('error', TextSystemConst::UPDATE_FAILED);
        }
    }
}
?>