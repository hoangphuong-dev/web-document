<div class="relative w-full rounded bg-white px-4 md:w-md md:px-8 py-4">
    <i class="absolute right-2 !top-2 cursor-pointer" wire:click="$dispatch('closeModal', { force: true })">
        @svg('cancel', 'h-6 w-6')
    </i>

    <h3 class="text-2xl font-medium my-2 text-center">
        Thành công
    </h3>

    @if ($error)
        <div class="container space-y-3">
            <p class="text-center text-2xl">{!! $error !!}</p>
        </div>

        <div class="container mt-6">
            <button onclick="window.location.reload();" class="button-primary px-6 mx-auto has-loading">
                OK
            </button>
        </div>
    @else
        <div class="container space-y-4 text-center">
            <p class="text-center text-2xl font-bold">
                Bạn đã thanh toán thành công
            <p class="text-center text-primary font-bold text-xl">{{ Formatter::numberFormatVn($transaction->money) }}</p>
            </p>
            <p>Nhấn tiếp tục hoặc liên hệ admin để nhận tài liệu</p>
        </div>

        <div class="container mt-6 text-center">
            <form class="space-y-4 my-4" wire:submit.prevent="tmpDownload">
                <button class="flex w-full items-center justify-center button-primary button-spinner cursor-pointer" type="submit">
                    <div wire:target='tmpDownload' wire:loading>@svg('spinner', 'h-5 w-5')</div>
                    <span class="uppercase leading-8">Tiếp tục</span>
                </button>
            </form>
        </div>
    @endif
</div>
