<?php

namespace App\Livewire\Popup;


use App\Services\User\AuthService;
use Illuminate\Http\Request;
use LivewireUI\Modal\ModalComponent;

class Login extends ModalComponent
{
    public string $email;
    public string $password;
    public bool   $remember = true;
    public string $currentUrl;

    public function mount(): void
    {
        $this->currentUrl = current_url();
    }

    protected function rules(): array
    {
        return [
            'email'    => ['required'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email không được để trống.',
            'password.required' => 'Mật khẩu không được để trống.',
        ];
    }

    /**
     * Attempt to authenticate a new session.
     *
     * @param  Request  $request
     * @return mixed
     */
    public function login(): mixed
    {
        $validated = $this->validate();
        return AuthService::login(
            username: $validated['email'],
            password: $validated['password'],
            remember: $this->remember,
            callback: function () {
                return redirect()->to($this->currentUrl);
            }
        );
    }

    public function render()
    {
        return view('livewire.popup.login');
    }
}
