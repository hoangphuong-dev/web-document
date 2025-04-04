<div x-data="searchPage">
    <div class="my-2 md:flex">
        <label class="whitespace-nowrap text-base font-bold mr-6">Tìm kiếm nâng cao :</label>
        <div class="grid md:grid-cols-2 gap-2 px-2 md:flex md:gap-8 py-0.5">
            @foreach (DocumentFilterAdvanced::asArray() as $advanced)
                <div class="{{ $advanced == request()->advanced ? 'text-primary' : '' }}">
                    <div @click="filter('advanced', '{{ $advanced }}')">
                        <input type="radio" class="accent-primary"
                            {{ $advanced == request()->advanced || (is_null(request()->advanced) && $advanced == DocumentFilterAdvanced::ALL_PHRASE) ? 'checked' : '' }}
                            id="{{ $advanced }}">
                        <label class="cursor-pointer hover:text-primary" for="{{ $advanced }}">
                            {{ DocumentFilterAdvanced::getDescription($advanced) }}
                        </label>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- @include('search.filter-static') --}}


</div>
@push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('searchPage', () => ({
                isShowCategory: false,
                isShowSort: false,
                isShowPage: false,
                isShowExtention: false,

                filter(type, value) {
                    const urlParams = new URLSearchParams(window.location.search);
                    urlParams.set(type, value);
                    window.location.search = urlParams;
                },
            }))
        })
    </script>
@endpush
