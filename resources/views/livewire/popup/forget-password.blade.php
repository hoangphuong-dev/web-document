<div class="relative w-full rounded bg-white px-4 md:w-md md:px-8 py-4">
    <i class="absolute right-2 !top-2 cursor-pointer" wire:click="$dispatch('closeModal', { force: true })">
        @svg('cancel', 'h-6 w-6')
    </i>

    <h3 class="text-center text-2xl font-medium m-[12px_0_15px]">
        Đặt lại mật khẩu
    </h3>

    <div class="flex flex-col">
        <div class="space-y-6">
            <form class="w-full space-y-6" wire:submit.prevent="resetPassword">
                <p class="space-y-1">
                    <label for="password"><b>Email tài khoản</b> <span class="text-danger">*</span></label>
                    <input type="text" class="block w-full leading-8 input @error('email') border-red-500 @enderror"
                        name="email" placeholder="Nhập email tài khoản" wire:model.defer="email">

                    @error('email')
                        <span class="!text-red-500 text-xs whitespace-normal block my-2">{{ $message }}</span>
                    @enderror
                </p>

                <x-alert></x-alert>
                
                <button type="submit" class="my-1 w-full uppercase button-primary button-spinner">
                    <div wire:loading>@svg('spinner', 'h-5 w-5')</div>
                    <span class="leading-8">Gửi yêu cầu</span>
                </button>
            </form>

            <div class="mt-4 text-center text-grey-dark">
                <a class="font-bold text-primary register" rel="nofollow" href="javascript:"
                    onclick="Livewire.dispatch('openModal', { component: 'popup.register' })">
                    Tạo tài khoản mới
                </a>.
            </div>

            <div class="mt-2 text-center text-grey-dark">
                Bạn đã có tài khoản?
                <a class="font-bold rounded text-primary login" rel="nofollow"
                    href="javascript:" onclick="Livewire.dispatch('openModal', { component: 'popup.login' })">
                    Đăng nhập
                </a>.
            </div>
        </div>
    </div>



</div>
