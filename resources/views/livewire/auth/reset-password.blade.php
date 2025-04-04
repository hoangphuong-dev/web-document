<form id="reset_password" class="mt-8 space-y-5" wire:submit.prevent="resetPassword">
    <input type="hidden" wire:model="token" name="token">
    <input type="hidden" wire:model="email" name="email">

    @if ($isFinished)
        <x-alert></x-alert>
    @else
        <div class="space-y-2">
            <div>
                <label class="mb-1 block text-sm font-bold" for="password">
                    Mật khẩu mới
                </label>
                <p class="mb-1 text-xs italic text-title-lighter">
                    * Mật khẩu phải có tối thiểu 8 ký tự, bao gồm cả chữ hoa, chữ thường và số.
                </p>
                <input class="w-full input @error('password') border-red-500 @enderror" wire:model.defer="password"
                    type="password" placeholder="••••••••">
                @error('password')
                    <span class="!text-red-500 whitespace-normal block mb-2">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="mb-1 block text-sm font-bold" for="password">
                    Nhập lại mật khẩu mới
                </label>
                <input class="w-full input @error('password_confirmation') border-red-500 @enderror"
                    wire:model.defer="password_confirmation" type="password" placeholder="••••••••">
                @error('password_confirmation')
                    <span class="!text-red-500 whitespace-normal block mb-2">{{ $message }}</span>
                @enderror
            </div>
            <x-alert></x-alert>
        </div>
        <button class="w-full button-primary button-spinner" type="submit">
            <div wire:loading>@svg('spinner', 'h-5 w-5')</div>
            Cập nhật
        </button>
    @endif
</form>
