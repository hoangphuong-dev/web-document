<div class="relative w-full rounded bg-white px-4 md:w-md md:px-8 py-4">
    <i class="absolute right-2 !top-2 cursor-pointer" wire:click="$dispatch('closeModal', { force: true })">
        @svg('cancel', 'h-6 w-6')
    </i>

    <h3 class="text-center text-2xl font-medium m-[12px_0_15px]">
        Đăng ký
    </h3>

    <div class="container space-y-6">
        <div class="w-full rounded bg-white py-2 text-black">
            <form wire:submit.prevent="register" class="space-y-8">
                <p class="space-y-1">
                    <label for="full_name"><b>Tên tài khoản</b> <span class="text-danger">*</span></label>
                    <input type="text" wire:model.defer="full_name"
                        class="block w-full leading-6 input rounded-md @error('full_name') border-red-500 @enderror"
                        name="full_name" id="full_name" placeholder="" />
                    @error('full_name')
                        <span class="block whitespace-normal text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </p>

                <p class="space-y-1">
                    <label for="email"><b>Email</b> <span class="text-danger">*</span></label>
                    <input type="email" wire:model.defer="email"
                        class="block w-full leading-6 input rounded-md @error('email') border-red-500 @enderror"
                        name="email" id="email" placeholder="" />
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

                <p class="space-y-1">
                    <label for="password_confirmation"><b>Nhập lại mật khẩu</b> <span
                            class="text-danger">*</span></label>
                    <input type="password" wire:model.defer="password_confirmation" autocomplete="off"
                        class="block w-full leading-6 input @error('password_confirmation') border-red-500 @enderror"
                        name="password_confirmation" id="password_confirmation" placeholder="••••••••" />
                    @error('password_confirmation')
                        <span class="block whitespace-normal text-xs text-red-500">{{ $message }}</span>
                    @enderror
                </p>

                <button type="submit" class="w-full rounded-lg uppercase leading-6 button-has-loading button-primary">
                    <span wire:loading>@svg('spinner', 'h-5 w-5')</span>
                    <span class="leading-8">Đăng ký</span>
                </button>
            </form>
        </div>

        <p class="w-full text-center  text-sm">
            <span class="px-3 bg-white">Hoặc đăng ký bằng</span>
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

        <div class="mt-4 text-grey-dark text-center pb-8">
            Bạn đã có tài khoản?
            <a class="cursor-pointer font-bold rounded text-primary login" rel="nofollow"
                href="javascript:"
                wire:click="$dispatch('openModal', { component: 'popup.login', arguments: {{ json_encode(['currentUrl' => $currentUrl]) }} })">
                Đăng nhập
            </a>
        </div>
    </div>

</div>
