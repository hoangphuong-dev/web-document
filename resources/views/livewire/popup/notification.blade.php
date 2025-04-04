<div class="relative w-full rounded bg-white px-4 md:w-md md:px-8 py-4">
    <i class="absolute right-2 !top-2 cursor-pointer" wire:click="$dispatch('closeModal', { force: true })">
        @svg('cancel', 'h-6 w-6')
    </i>

    <h3 class="text-2xl font-medium my-2">
        Thông báo
    </h3>

    <div class="space-y-3">
        <div class="my-4">
            <p class="text-base">{!! $message !!}</p>
        </div>
        <div class="py-2 text-right">
            @if ($reload)
                <button onclick="window.location.reload();" class="button-primary px-6">
                    OK
                </button>
            @else
                <button wire:click="$dispatch('closeModal')" class="button-primary px-6">
                    OK
                </button>
            @endif
        </div>
    </div>
</div>
