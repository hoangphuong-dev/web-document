<div class="my-4 grid grid-cols-6 gap-2 lg:grid-cols-12">
    {{-- Danh mục --}}
    <div @click="isShowCategory = true"
        class="z-50 col-span-12 transform cursor-pointer rounded bg-white py-2 input md:static md:col-span-3 md:translate-y-0">
        <div class="text-center">
            <a class="relative mr-4 whitespace-nowrap text-center">
                <span>Danh mục: </span>
                <span class="font-bold text-primary">
                    @php $catCurrent = $categories['menuParent']->where('id', request()->category)->first();@endphp
                    {{ $catCurrent?->name ?? 'Tất cả danh mục' }}
                </span>
            </a>
            @svg('arrow-up-down', 'absolute h-5 right-0  top-2 w-5')
        </div>
        <div @click.away="isShowCategory = false" x-show="isShowCategory" style="display: none"
            class="absolute bottom-0 w-full translate-y-full transform overflow-y-scroll rounded border bg-white -left-[1px] border-primary z-[1000] h-[400px]">
            @php $catId = request()->id ?? 0; @endphp
            <div
                class="px-3 leading-9 hover:bg-primary hover:text-white {{ $catId == 0 ? 'bg-primary text-white' : '' }}">
                <div @click="filter('category', '', '')">
                    Tất cả danh mục
                </div>
            </div>
            <hr>
            @foreach ($categories['menuParent'] as $parent)
                <div
                    class="relative z-20 flex items-center justify-between bg-white hover:bg-primary hover:text-white {{ $parent->id == $catId ? '!bg-primary !text-white' : 'bg-white' }}">
                    <div class="block grow pl-3 leading-9" x-on:click="filter('category', '{{ $parent->id }}')">
                        {{ $parent->name }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Sắp xếp --}}
    <div @click="isShowSort = true"
        class="z-40 col-span-12 transform cursor-pointer rounded bg-white py-2 input md:static md:col-span-3 md:translate-y-0">
        <div class="text-center">
            <a class="relative mr-4 whites pace-nowrap text-center">
                <span>Sắp xếp: </span>
                <span class="font-bold text-primary">
                    {{ DocumentSort::getDescription(request()->sort) }}
                </span>
            </a>
            @svg('arrow-up-down', 'absolute h-5 right-0  top-2 w-5')
        </div>
        <div @click.away="isShowSort = false" x-show="isShowSort" style="display: none"
            class="absolute bottom-0 w-full translate-y-full transform rounded border bg-white -left-[1px]">
            @foreach (DocumentSort::asArray() as $index => $value)
                <div @click="filter('sort', '{{ $value }}')">
                    <div
                        class="px-2 leading-8 hover:bg-primary-darker hover:text-white 
                        {{ $value == request()->sort ? 'bg-primary text-white' : '' }}">
                        {{ DocumentSort::getDescription($value) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Loại file --}}
    <div @click="isShowExtention = true"
        class="z-30 col-span-12 transform cursor-pointer rounded bg-white py-2 input md:static md:col-span-3 md:translate-y-0">
        <div class="text-center">
            <a class="relative mr-4 whites pace-nowrap text-center">
                <span>Loại file: </span>
                <span class="font-bold text-primary">
                    {{ DocumentExt::getDescription(request()->ext) }}
                </span>
            </a>
            @svg('arrow-up-down', 'absolute h-5 right-0  top-2 w-5')
        </div>
        <div @click.away="isShowExtention = false" x-show="isShowExtention" style="display: none"
            class="absolute bottom-0 w-full translate-y-full transform rounded border bg-white -left-[1px]">
            @foreach (DocumentExt::asArray() as $index => $value)
                <div @click="filter('ext', '{{ $value }}')">
                    <div
                        class="px-2 leading-8 hover:bg-primary-darker hover:text-white 
                        {{ $value == request()->ext ? 'bg-primary text-white' : '' }}">
                        {{ DocumentExt::getDescription($value) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Độ dài trang --}}
    <div @click="isShowPage = true"
        class="z-20 col-span-12 transform cursor-pointer rounded bg-white py-2 input md:static md:col-span-3 md:translate-y-0">
        <div class="text-center">
            <a class="relative mr-4 whites pace-nowrap text-center">
                <span>Độ dài: </span>
                <span class="font-bold text-primary">
                    {{ DocumentFilterPage::getDescription(request()->length) }}
                </span>
            </a>
            @svg('arrow-up-down', 'absolute h-5 right-0  top-2 w-5')
        </div>
        <div @click.away="isShowPage = false" x-show="isShowPage" style="display: none"
            class="absolute bottom-0 w-full translate-y-full transform rounded border bg-white -left-[1px]">
            @foreach (DocumentFilterPage::asArray() as $index => $value)
                <div @click="filter('length', '{{ $value }}')">
                    <div
                        class="px-2 leading-8 hover:bg-primary-darker hover:text-white 
                        {{ $value == request()->length ? 'bg-primary text-white' : '' }}">
                        {{ DocumentFilterPage::getDescription($value) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
