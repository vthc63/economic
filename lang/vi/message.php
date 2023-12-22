<?php

return [
    'required' => 'Vui lòng nhập :attribute',
    'min_max_length' => ':attribute tối thiểu :min kí tự và tối đa :max kí tự',
    'email' => 'Địa chỉ email không hợp lệ',
    'unique' => ':attribute này đã được sử dụng',
    'min' => ':attribute tối thiểu :min kí tự',
    'max' => ':attribute tối đa :max kí tự',
    'password_invalidator' => ':attribute bao gồm từ 8 - 24 kí tự, ít nhất một chữ cái in hoa, một chữ cái in thường, một số và một kí tự đặc biệt (%, #, @, _, \, -) ', 
    'password' => [
        'min_max_length' => 'Mật khẩu tối thiểu :min kí tự và tối đa :max kí tự',
        'check_password' => 'Vui lòng nhập mật khẩu bao gồm ít nhất một chữ cái in hoa, một chữ cái tự in thường và một kí tự đặc biệt (%, #, @, _, \, -) ',
        'required' => 'Vui lòng nhập mật khẩu',
        'mixed' => 'Mật khẩu phải chứa ít nhất một chữ hoa và một chữ thường',
        'letters' => 'Mật khẩu phải có ít nhất 8 kí tự',
        'at_least_one_lowercase_letter_is_required' => 'Mật khẩu chứa ít nhất một chữ cái in thường',
        'at_least_one_uppercase_letter_is_required' => 'Mật Khẩu chứa ít nhất một chữ cái in hoa',
        'at_least_one_digit_is_required' => 'ít nhất một chữ số',
        'at_least_special_characte_is_required' => 'Mật khẩu phải chứa ít nhất 1 kí tự đặc biệt (%, #, @, _, /, -)',
    ],
];