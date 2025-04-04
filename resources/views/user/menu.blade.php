<div x-data="{ openUserPopup: false }">
    @php $user = Auth::user(); @endphp
    <div @click="openUserPopup = !openUserPopup">
        <span class="relative float-left mr-2 h-8 w-8 overflow-visible">
            <img class="rounded-full lazycursor-pointer w-full h-full loaded border"
                src="{{ ImageHelper::getImageDefault('user') }}" alt="{{ $user->full_name }}" data-ll-status="loaded">
        </span>
        <a class="hidden overflow-hidden text-ellipsis whitespace-nowrap font-bold max-w-[115px] leading-[33px] lg:block"
            href="javascript:void(0);" rel="nofollow" id="header-name">
            {{ $user->full_name }}
        </a>
    </div>

    <div x-cloak x-show="openUserPopup" class="absolute top-16 -right-16 border rounded bg-white shadow-2xl">
        {{-- <span
            class="bg-white group-hover:bg-primary-100/[0.2] -translate-x-[100%] md:-translate-x-[75%] md:block absolute w-4 h-4 rotate-45 right-0 border-t border-l border-solid border-slate-300 -translate-y-[35px] md:-translate-y-[41px] )"></span> --}}

        <ul class="overflow-hidden">
            <li class="w-48 cursor-pointer p-2 hover:text-white hover:bg-primary">
                <a class="block" href="#">
                    Thông tin cá nhân
                </a>
            </li>
            <li class="w-48 cursor-pointer p-2 hover:text-white hover:bg-primary">
                <a class="block" href="#">
                    Quản lý tài liệu
                </a>
            </li>

            <li class="w-48 cursor-pointer p-2 hover:text-white hover:bg-primary">
                <form method="post" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="block w-full text-left" id="logout-btn">
                        Đăng xuất
                    </button>
                </form>
            </li>
        </ul>
    </div>

</div>
