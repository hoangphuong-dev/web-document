<?php

namespace App\Livewire\Popup;


use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\PasswordValidationRules;
use App\Services\User\UserService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Validator;
use LivewireUI\Modal\ModalComponent;

class Register extends ModalComponent
{
    use PasswordValidationRules;

    public string $full_name             = '';
    public string $phone_number          = '';
    public string $email                 = '';
    public string $password              = '';
    public string $password_confirmation = '';
    public string $captcha               = '';
    public string $currentUrl            = '';

    public function mount(): void
    {
        $this->currentUrl = current_url();
    }

    public function messages(): array
    {
        return [
            'full_name.required'       => 'Tên tài khoản không được để trống',
            'email.required'           => 'Email không được để trống',
            ...$this->passwordMessages(),
        ];
    }

    protected function rules(): array
    {
        return [
            'full_name'             => ['required', 'string', 'max:255'],
            'phone_number'          => ['nullable', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'min:10'],
            'email'                 => ['required', 'string', 'email', 'max:255'],
            'password'              => $this->passwordRules(),
        ];
    }

    public function register(CreateNewUser $creator)
    {
        $data = $this->withValidator(function (Validator $validator) {
            $validator->after(function ($validator) {
                if (UserService::userActiveExistsByEmail($this->email)) {
                    $validator->errors()->add('email', 'Email đã tồn tại');
                }
            });
        })->validate();

        event(new Registered($user = $creator->create($data)));

        Auth::guard(config('fortify.guard'))->login($user);

        $this->destroySkippedModals();

        $message = "Chúng tôi vừa gửi một email xác thực tới <b>{$this->email}</b> </br> </br>
        <p class='text-base !text-success '>Vui lòng kích hoạt tài khoản bằng cách làm theo hướng dẫn trong email.</p>";

        return $this->dispatch('openModal', 'popup.notification', [
            'message' => $message,
            'reload' => true
        ]);
    }

    public function render()
    {
        return view('livewire.popup.register');
    }
}
