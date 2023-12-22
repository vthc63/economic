<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $databases = [
            [
                'table' => 'roles',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Quản trị viên',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Nhân Viên',
                    ],
                    [
                        'id' => 3,
                        'name' => 'Khách hàng',
                    ]
                ],
            ],
            [
                'table' => 'users',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Admin',
                        'email' => 'admin@gmail.com',
                        'password' => Hash::make('Rootadmin123'),
                        'email_verified_at' => now(),
                        'phone_number' => '0271728199',
                        'active' => 1,
                        'role_id' => 1
                    ],
                    [
                        'id' => 2,
                        'name' => 'Nhân viên 1',
                        'email' => 'nv1@gmail.com',
                        'password' => Hash::make('Nhanvien1'),
                        'email_verified_at' => now(),
                        'phone_number' => '0271763986',
                        'active' => 1,
                        'role_id' => 2
                    ],
                    [
                        'id' => 3,
                        'name' => 'huechi',
                        'email' => 'vthc@gmail.com',
                        'password' => Hash::make('huechi1234'),
                        'email_verified_at' => now(),
                        'phone_number' => '0271763333',
                        'active' => 1,
                        'role_id' => 3
                    ]

                ]
            ],
            [
                'table' => 'brands',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Nike'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Gucci'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Adidas'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Chanel'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Uniqlo'
                    ],
                ]
            ],
            [
                'table' => 'categories',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Thời Trang Nam',
                        'parent_id' => 0,
                        'slug' => 'thoi-trang-nam'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Thời Trang Nữ',
                        'parent_id' => 0,
                        'slug' => 'thoi-trang-nu'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Áo polo',
                        'parent_id' => 1,
                        'slug' => 'ao-polo'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Áo thể thao',
                        'parent_id' => 1,
                        'slug' => 'ao-the-thao'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Áo Sơ Mi',
                        'parent_id' => 1,
                        'slug' => 'ao-so-mi'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Áo Thun',
                        'parent_id' => 1,
                        'slug' => 'ao-thun'
                    ],
                    [
                        'id' => 7,
                        'name' => 'Quần Jeans',
                        'parent_id' => 1,
                        'slug' => 'quan-jeans'
                    ],
                    [
                        'id' => 8,
                        'name' => 'Quần Shorts',
                        'parent_id' => 1,
                        'slug' => 'quan-shorts'
                    ],
                    [
                        'id' => 9,
                        'name' => 'Áo Thun',
                        'parent_id' => 2,
                        'slug' => 'ao-thun-1'
                    ],
                    [
                        'id' => 10,
                        'name' => 'Đầm Váy',
                        'parent_id' => 2,
                        'slug' => 'dam-vay'
                    ],
                    [
                        'id' => 11,
                        'name' => 'Áo Sơ Mi',
                        'parent_id' => 2,
                        'slug' => 'ao-so-mi-1'
                    ],
                    [
                        'id' => 12,
                        'name' => 'Chân Váy',
                        'parent_id' => 2,
                        'slug' => 'chan-vay'
                    ],
                    [
                        'id' => 13,
                        'name' => 'Quần Jeans',
                        'parent_id' => 2,
                        'slug' => 'quan-jeans-1'
                    ],
                ]
            ],
            [
                'table' => 'payments',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Khi nhận hàng',
                        'status' => 1,
                        'img' => '1682960154.png',
                    ],
                    [
                        'id' => 2,
                        'name' => 'Ví điện tử Momo',
                        'status' => 1,
                        'img' => '1682960202.png',
                    ],
                    [
                        'id' => 3,
                        'name' => 'VNPAY',
                        'status' => 1,
                        'img' => '1694970935.png',
                    ],
                ]
            ],
            [
                'table' => 'colors',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'Trắng'
                    ],
                    [
                        'id' => 2,
                        'name' => 'Đen'
                    ],
                    [
                        'id' => 3,
                        'name' => 'Xám'
                    ],
                    [
                        'id' => 4,
                        'name' => 'Đỏ'
                    ],
                    [
                        'id' => 5,
                        'name' => 'Vàng'
                    ],
                    [
                        'id' => 6,
                        'name' => 'Xanh'
                    ],
                    [
                        'id' => 7,
                        'name' => 'Tím'
                    ],
                ]
            ],
            [
                'table' => 'sizes',
                'data' => [
                    [
                        'id' => 1,
                        'name' => 'S'
                    ],
                    [
                        'id' => 2,
                        'name' => 'M'
                    ],
                    [
                        'id' => 3,
                        'name' => 'L'
                    ],
                    [
                        'id' => 4,
                        'name' => 'XL'
                    ],
                ]
            ],
            [
                'table' => 'setting',
                'data' => [
                    [
                        'id' => 1,
                        'logo' => 'logo.png',
                        'name' => 'MintShop',
                        'email' => 'MintShop@gmail.com',
                        'address' => '221 Võ Văn Ngân, quận Thủ Đức, thành phố Hồ Chí Minh',
                        'phone_number' => '123125934093',
                        'maintenance' => 2,
                        'notification' => '<b>WEBSITE tạm thời bảo trì để nâng cấp xin quay lại sau</b>',
                        'introduction' => '
                            <h3 style="text-align: center; ">
                            <b>GIỚI THIỆU MINTSHOP</b>
                            </h3><h5><br></h5><h5><span style="font-family: " source="" sans="" pro";"="" times="" new="" roman"; "="">
                            Chào mừng đến với website bán thời trang của chúng tôi! 
                            Chúng tôi tự hào là một trong những cửa hàng trực tuyến hàng đầu về thời trang, 
                            cung cấp cho khách hàng những sản phẩm thời trang chất lượng cao và đa dạng.
                            </span><br></h5><h5><br></h5><h5>
                            Đối với chúng tôi, thời trang là một niềm đam mê và một nghệ thuật. 
                            Chúng tôi không chỉ cung cấp cho khách hàng những sản phẩm thời trang đẹp và chất lượng, 
                            mà còn mang đến cho họ những trải nghiệm mua sắm tuyệt vời. Chúng tôi luôn nỗ lực để đáp ứng nhu cầu của khách hàng,
                            từ việc cung cấp những sản phẩm mới nhất đến việc cải tiến dịch vụ khách hàng.
                            <br></h5><h5><br></h5><h5>
                            Chúng tôi cam kết chỉ bán những sản phẩm thời trang được làm từ chất liệu tốt nhất, 
                            đảm bảo độ bền cao và giá trị sử dụng lâu dài. Chúng tôi luôn đảm bảo rằng mỗi sản phẩm đều được kiểm tra kỹ lưỡng trước khi đưa vào bán hàng, 
                            để đảm bảo rằng chúng đáp ứng các tiêu chuẩn chất lượng mà chúng tôi đặt ra.
                            <br></h5><h5><br></h5><h5>
                            Chúng tôi luôn cập nhật các xu hướng thời trang mới nhất, 
                            đảm bảo rằng bạn sẽ luôn có những sản phẩm đẹp và phù hợp với phong cách của mình. 
                            Từ những bộ cánh phong cách đường phố đến những thiết kế sang trọng cho các buổi tiệc, 
                            chúng tôi có tất cả những gì bạn cần để thể hiện phong cách cá nhân của mình.
                            <br></h5><h5><br></h5><h5>Ngoài ra, 
                            chúng tôi cũng cung cấp cho khách hàng các phụ kiện thời trang đa dạng, từ giày dép, túi xách, 
                            đồng hồ đến trang sức và nhiều thứ khác, giúp khách hàng hoàn thiện phong cách của mình một cách tuyệt vời.
                            <br></h5><h5><br></h5><h5>
                            Đội ngũ nhân viên của chúng tôi luôn sẵn sàng hỗ trợ bạn trong quá trình mua sắm. 
                            Chúng tôi cam kết đem đến cho khách hàng những trải nghiệm mua sắm tuyệt vời, từ việc tìm kiếm sản phẩm đến việc đặt hàng và nhận hàng.
                            </h5><p><br></p><h5>
                            Chúng tôi tự hào giới thiệu cho bạn những sản phẩm thời trang đa dạng và phong phú. 
                            Từ những bộ cánh casual hàng ngày đến những thiết kế sang trọng cho các dịp đặc biệt, 
                            chúng tôi có tất cả những gì bạn cần để thể hiện phong cách cá nhân của mình.
                            <br></h5><h5><br></h5><h5>Với những thiết kế đa dạng, 
                            chúng tôi cam kết đem đến cho khách hàng những trải nghiệm mua sắm tuyệt vời. 
                            Những sản phẩm của chúng tôi được thiết kế và sản xuất bởi những thương hiệu nổi tiếng trên thế giới, 
                            đảm bảo về chất lượng và độ bền.<br></h5><h5><br></h5><h5>Nếu bạn đang tìm kiếm những bộ cánh năng động và trẻ trung, 
                            hãy khám phá các sản phẩm áo thun, quần jean, áo khoác bomber, 
                            hoặc các thiết kế streetwear đầy phong cách. 
                            Nếu bạn cần một bộ cánh lịch sự cho một buổi tiệc hoặc sự kiện quan trọng, 
                            chúng tôi cũng có các thiết kế sang trọng như váy dạ hội, đầm maxi, áo sơ mi hay quần tây.
                            <br></h5><h5><br></h5><h5>
                            Ngoài ra, chúng tôi cũng cung cấp các sản phẩm thời trang thể thao, 
                            đáp ứng nhu cầu của những khách hàng yêu thích các hoạt động thể thao và thích sự thoải mái khi mặc.
                            <br>
                            Hãy truy cập vào website của chúng tôi để khám phá thêm các sản phẩm thời trang đa dạng và phong phú. 
                            Chúng tôi tin rằng, bạn sẽ tìm thấy những sản phẩm ưng ý và phù hợp với phong cách cá nhân của mình.</h5>
                        '
                    ],
                ]
            ]
        ];

        foreach ($databases as $database ) {
            $recordNumber = DB::table($database['table'])->count();
            foreach ($database['data'] as $key => $record) {
                if ($key >= $recordNumber)
                DB::table($database['table'])->insert($record);
            }
        }
    }
}