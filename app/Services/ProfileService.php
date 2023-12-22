<?php

namespace App\Services;

use App\Helpers\TextSystemConst;
use App\Http\Requests\Admin\ChangePasswordRequest;
use App\Http\Requests\Admin\UpdateProfileRequest;
use App\Models\Role;
use App\Models\UserVerify;
use App\Notifications\VerifyUser;
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


class ProfileService 
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

    /**
     * Show the form for creating a new user.
     *
     * @return array
     */
    public function changeProfile()
    {
        try {
            $user = Auth::guard('admin')->user();
            $response = Http::withHeaders([
                'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
                ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/province');
            $data = json_decode($response->body(), true);
            foreach ($data['data'] as $item) {
                $provinces[] = [
                    'value' => $item['ProvinceID'],
                    'text' => $item['NameExtension'][1],
                ];
            }
            
            $response = Http::withHeaders([
                'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
                ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/district', [
                    'province_id' => old('city') ?? $user->address->city,
                ]);
                $data = json_decode($response->body(), true);
                foreach ($data['data'] as $item) {
                    $districts[] = [
                        'value' => $item['DistrictID'],
                        'text' => $item['DistrictName'],
                    ];
                }
                
                $response = Http::withHeaders([
                    'token' => '24d5b95c-7cde-11ed-be76-3233f989b8f3'
                    ])->get('https://online-gateway.ghn.vn/shiip/public-api/master-data/ward', [
                        'district_id' => old('district') ?? $user->address->district,
                    ]);
                    $data = json_decode($response->body(), true);
                    foreach ($data['data'] as $item) {
                        $wards[] = [
                            'value' => $item['WardCode'],
                            'text' => $item['NameExtension'][0],
                        ];
                    }
            // Fields form
            $fields = [
                [
                    'attribute' => 'name',
                    'label' => 'Họ Và Tên',
                    'type' => 'text',
                    'value' => $user->name,
                ],
                [
                    'attribute' => 'email',
                    'label' => 'Email',
                    'type' => 'email',
                    'value' => $user->email,
                ],
                [
                    'attribute' => 'phone_number',
                    'label' => 'Số Điện Thoại',
                    'type' => 'text',
                    'format_phone' => true,
                    'value' => $user->phone_number,
                ],
                [
                    'attribute' => 'city',
                    'label' => 'Tỉnh, Thành Phố',
                    'type' => 'select',
                    'list' => $provinces,
                    'value' => old('city') ?? $user->address->city,
                ],
                [
                    'attribute' => 'district',
                    'label' => 'Quận, Huyện',
                    'type' => 'select',
                    'list' => $districts,
                    'value' => old('district') ?? $user->address->district,
                ],
                [
                    'attribute' => 'ward',
                    'label' => 'Phường, Xã',
                    'type' => 'select',
                    'list' =>  $wards,
                    'value' => old('ward') ?? $user->address->ward,
                ],
                [
                    'attribute' => 'apartment_number',
                    'label' => 'Số Nhà',
                    'type' => 'text',
                    'value' => $user->address->apartment_number,
                ],
            ];
    
            //Rules form
            $rules = [
                'email' => [
                    'required' => true,
                    'email' => true,
                ],
                'name' => [
                    'required' => true,
                    'minlength' => 1,
                    'maxlength' => 30,
                ],
                'apartment_number' => [
                    'required' => true,
                ],
                'city' => [
                    'required' => true,
                ],
                'district' => [
                    'required' => true,
                ],
                'ward' => [
                    'required' => true,
                ],
                'phone_number' => [
                    'required' => true,
                    'minlength' => 12,
                    'maxlength' => 12,
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'name' => [
                    'required' => __('message.required', ['attribute' => 'Họ và tên']),
                    'minlength' => __('message.min', ['min' => 1, 'attribute' => 'Họ và tên']),
                    'maxlength' => __('message.max', ['max' => 30, 'attribute' => 'Họ và tên']),
                ],
                'email' => [
                    'required' => __('message.required', ['attribute' => 'email']),
                    'email' => __('message.email'),
                ],
                'phone_number' => [
                    'required' => __('message.required', ['attribute' => 'số điện thoại']),
                    'minlength' => __('message.min', ['attribute' => 'số điện thoại', 'min' => 10]),
                    'maxlength' => __('message.max', ['attribute' => 'số điện thoại', 'max' => 10]),
                ],
                'city' => [
                    'required' =>  __('message.required', ['attribute' => 'tỉnh, thành phố']),
                ],
                'district' =>[
                    'required' =>  __('message.required', ['attribute' => 'quận, huyện']),
                ],
                'ward' => [
                    'required' => __('message.required', ['attribute' => 'phường, xã']),
                ],
                'apartment_number' => [
                    'required' =>  __('message.required', ['attribute' => 'số nhà']),
                ],

            ];
            return [
                'title' => TextLayoutTitle("profile"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
            ];
        } catch (Exception) {
            return[];
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = $this->userRepository->find(Auth::guard('admin')->user()->id);
            $data = $request->validated();
            // user data request
            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
                'phone_number' => $data['phone_number'],
                'role_id' => $user->role_id,
                'updated_by' => Auth::guard('admin')->user()->id,
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
                $user->notify(new VerifyUser($token));
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

    public function changePassword()
    {
        try {
            // Fields form
            $fields = [
                [
                    'attribute' => 'current_password',
                    'label' => 'Mật Khẩu Cũ',
                    'type' => 'password',
                    'autocomplete' => 'new-password',
                ],
                [
                    'attribute' => 'new_password',
                    'label' => 'Mật Khẩu Mới',
                    'type' => 'password',
                    'autocomplete' => 'new-password',
                ],
                [
                    'attribute' => 'confirm_password',
                    'label' => 'Xác Nhận Mật Khẩu',
                    'type' => 'password',
                    'autocomplete' => 'new-password',
                ],
            ];
    
            //Rules form
            $rules = [
                'current_password' => [
                    'required' => true,
                ],
                'new_password' => [
                    'required' => true,
                    'minlength' => 8,
                    'maxlength' => 24,
                    'checklower' => true,
                    'checkupper' => true,
                    'checkdigit' => true,
                    'checkspecialcharacter' => true,
                ],
                'confirm_password' => [
                    'equalTo' => '#new_password',
                ],
            ];
    
            // Messages eror rules
            $messages = [
                'current_password' => [
                    'required' => __('message.required', ['attribute' => 'mật khẩu hiện tại']),
                ],
                'new_password' => [
                    'required' => __('message.required', ['attribute' => 'mật khẩu mới']),
                    'minlength' => __('message.min', ['attribute' => 'Mật khẩu mới', 'min' => 8]),
                    'maxlength' => __('message.max', ['attribute' => 'Mật khẩu mới', 'max' => 24]),
                    'checklower' => __('message.password.at_least_one_lowercase_letter_is_required'),
                    'checkupper' => __('message.password.at_least_one_uppercase_letter_is_required'),
                    'checkdigit' => __('message.password.at_least_one_digit_is_required'),
                    'checkspecialcharacter' => __('message.password.at_least_special_characte_is_required'),
                ],
                'confirm_password' => [
                    'equalTo' => 'Xác nhận mật khẩu không trùng khớp',
                ],
            ];
            return [
                'title' => TextLayoutTitle("change_password"),
                'fields' => $fields,
                'rules' => $rules,
                'messages' => $messages,
            ];
        } catch (Exception) {
            return[];
        }
    }

    public function updatePassword(ChangePasswordRequest $request)
    {
        try {
            $request->validated();
            $data = [
                'password' => $request->new_password,
                'updated_by' => Auth::guard('admin')->user()->id,
            ];
            $user = $this->userRepository->find(Auth::guard('admin')->user()->id);
            $this->userRepository->update($user, $data);
            return back()->with('success', TextSystemConst::CHANGE_PASSWORD['success']);
        } catch (Exception) {
            return back()->with('error', TextSystemConst::CHANGE_PASSWORD['error']);
        }
    }
}
?>