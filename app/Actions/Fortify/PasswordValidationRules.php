<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Rules cho password
     *
     * @param  bool  $needConfirm  Có xác nhận mật khẩu hay không
     *
     * @return array<int, Rule|array|string>
     */
    protected function passwordRules(bool $needConfirm = true): array
    {
        $rules = [
            'required',
            'string',
            Password::min(8)->mixedCase()->numbers(),
        ];

        if ($needConfirm) {
            $rules[] = 'confirmed';
        }

        return $rules;
    }

    protected function passwordMessages(): array
    {
        return [
            'password.required'  => 'Vui lòng nhập mật khẩu',
            'password.string'    => 'Mật khẩu không hợp lệ',
            'password.min'       => 'Mật khẩu phải có ít nhất 8 ký tự',
            'password.mixedCase' => 'Mật khẩu phải có ít nhất 1 chữ hoa và 1 chữ thường',
            'password.numbers'   => 'Mật khẩu phải có ít nhất 1 chữ số',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ];
    }
}
