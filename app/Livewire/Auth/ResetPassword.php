<?php

namespace App\Livewire\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Enums\Common\AlertType;
use App\Models\User;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Actions\CompletePasswordReset;
use Laravel\Fortify\Contracts\ResetsUserPasswords;
use Livewire\Component;

class ResetPassword extends Component
{
    use PasswordValidationRules;

    public string $token                 = '';
    public string $email                 = '';
    public string $password              = '';
    public string $password_confirmation = '';
    public bool $isFinished              = false;

    protected function rules(): array
    {
        return [
            'password'              => $this->passwordRules(),
            'password_confirmation' => 'required|same:password',
            'email'                 => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::exists(User::class, 'email'),
            ],
            'token'                 => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'    => 'Mật khẩu không được để trống.',
            'password_confirmation.required' => 'Xác nhận mật khẩu không được để trống.',
            ...$this->passwordMessages(),
        ];
    }

    public function resetPassword(StatefulGuard $guard)
    {
        $data   = $this->validate();
        $status = Password::broker(config('fortify.passwords'))->reset(
            $data,
            function ($user) use ($guard, $data) {
                app(ResetsUserPasswords::class)->reset($user, $data);
                app(CompletePasswordReset::class)($guard, $user);
            }
        );

        switch ($status) {
            case Password::PASSWORD_RESET:
                $this->isFinished = true;
                notify('Mật khẩu của bạn đã được cập nhật thành công. Bạn có thể đăng nhập bằng mật khẩu mới.', AlertType::SUCCESS);
                break;

            case Password::INVALID_TOKEN:
                notify('Token không hợp lệ.', AlertType::ERROR);
                break;

            case Password::INVALID_USER:
                notify('Email không tồn tại.', AlertType::ERROR);
                break;

            default:
                notify('Có lỗi xảy ra, vui lòng thử lại sau.', AlertType::ERROR);
                break;
        }
    }

    public function updated($propertyName)
    {
        $this->resetValidation($propertyName);
    }

    public function render()
    {
        return view('livewire.auth.reset-password');
    }
}
