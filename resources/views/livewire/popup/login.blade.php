<div class="relative w-full rounded bg-white px-4 md:w-md md:px-8 py-4">
    <i class="absolute right-2 !top-2 cursor-pointer" wire:click="$dispatch('closeModal', { force: true })">
        @svg('cancel', 'h-6 w-6')
    </i>

    <h3 class="text-center text-2xl font-medium m-[12px_0_15px]">
        Đăng nhập
    </h3>

    <div class="container">
        <div class="w-full rounded bg-white py-2 text-black space-y-10">
            <form class="space-y-4" wire:submit.prevent="login">
                <p class="space-y-1">
                    <label for="email"><b>Email</b> <span class="text-danger">*</span></label>
                    <input type="email" wire:model.defer="email"
                        class="block w-full leading-6 input rounded-md @error('email') border-red-500 @enderror"
                        name="email" id="email" />
                    @error('email')
                        <span class="block whitespace-normal text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </p>

                <p class="space-y-1">
                    <label for="password"><b>Mật khẩu</b> <span class="text-danger">*</span></label>
                    <input type="password" wire:model.defer="password" autocomplete="off"
                        class="block w-full leading-6 input @error('password') border-red-500 @enderror" name="password"
                        id="password" placeholder="••••••••" />
                    @error('password')
                        <span class="block whitespace-normal text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </p>

                <div class="flex items-center justify-between">
                    <p>
                        <input class="accent-primary" id="remember" type="checkbox" name="remember"
                            wire:model.defer="remember" />
                        <label for="remember" class="cursor-pointer">Nhớ mật khẩu</label>
                    </p>

                    <button type="button" class="cursor-pointer text-primary font-bold"
                        onclick="Livewire.dispatch('openModal', { component: 'popup.forget-password' })">
                        Quên mật khẩu
                    </button>
                </div>

                <button id="submitLogin" class="flex w-full items-center justify-center button-primary button-spinner"
                    type="submit">
                    <div wire:loading>@svg('spinner', 'h-5 w-5')</div>
                    <span class="uppercase leading-8">Đăng Nhập</span>
                </button>
            </form>

            <p class="w-full text-center  text-sm">
                <span class="px-3 bg-white">Hoặc đăng nhập bằng</span>
            </p>
            <hr style="margin-top: -10px; padding-bottom: 10px">

            <div class="flex gap-2 justify-center">
                @foreach (\App\Enums\User\SocialProvider::asArray() as $item)
                    @php $iconName = $item . '-color' @endphp
                    <div class="w-32 rounded-md border bg-white text-center hover:bg-default">
                        <a class="flex items-center justify-center space-x-2 w-full border-slate-300" rel="nofollow"
                            href="{{ route('auth.social.redirect', ['provider' => $item]) }}">
                            @svg($iconName, 'w-6 h-6 shrink-0')
                            <span class="py-2 text-sm">
                                {{ \Str::title($item) }}
                            </span>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="text-center">
                <span>Bạn chưa có tài khoản?</span>
                <span type="button" class="cursor-pointer text-primary font-bold"
                    wire:click="$dispatch('openModal', { component: 'popup.register' })">
                    Đăng ký
                </span>
            </div>

            <div class="text-center text-xs">
                Bằng việc nhấn Đăng nhập, bạn xác nhận đã đọc và đồng ý với Điều khoản sử dụng và Chính sách bảo vệ dữ
                liệu cá nhân của {{ config('app.name') }}
            </div>

        </div>

    </div>
</div>
