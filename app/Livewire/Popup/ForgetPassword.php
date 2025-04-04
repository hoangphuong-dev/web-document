<?php

namespace App\Livewire\Popup;

use App\Enums\Common\AlertType;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Password;
use LivewireUI\Modal\ModalComponent;

class ForgetPassword extends ModalComponent
{
    public string $email;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email không được để trống.',
        ];
    }

    public function resetPassword()
    {
        $validated = $this->validate();

        $status = $this->broker()->sendResetLink(['email' => $validated['email']]);
        switch ($status) {
            case Password::RESET_LINK_SENT:
                notify('Đã gửi liên kết đặt lại mật khẩu vào email của bạn.', AlertType::SUCCESS);
                break;

            case Password::INVALID_USER:
                notify('Không tìm thấy tài khoản với email này.', AlertType::ERROR);
                break;

            default:
                notify('Đã có lỗi xảy ra, vui lòng thử lại sau.', AlertType::ERROR);
        }
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return PasswordBroker
     */
    protected function broker(): PasswordBroker
    {
        return Password::broker(config('fortify.passwords'));
    }

    public function render()
    {
        return view('livewire.popup.forget-password');
    }
}
