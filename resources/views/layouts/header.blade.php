<header x-data="{ open_list_mobile: false, open_search_mobile: false, openUserPopup: false }" id="header" class="w-full bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="container max-w-screen-xl mx-auto px-4 md:px-0">
        <!-- Desktop & Mobile Layout -->
        <div class="flex items-center justify-between h-16 md:h-20">
            <!-- Left Side: Logo & Mobile Search Button -->
            <div class="flex items-center">
                <!-- Mobile Search Button -->
                <button class="block md:hidden text-gray-600 hover:text-primary mr-2" aria-label="Tìm kiếm"
                    @click="open_search_mobile = !open_search_mobile" title="Tìm kiếm">
                    @svg('search', 'h-5 w-5')
                </button>

                <!-- Logo -->
                <a href="{{ route('index') }}" class="flex-shrink-0 text-center" aria-label="Trang chủ">
                    <span class="text-2xl text-primary font-bold">✨ KhoSangKien ✨</span>
                </a>
            </div>

            <!-- Center: Desktop Search -->
            <div class="hidden md:flex flex-1 mx-6 lg:mx-10">
                <form method="GET" action="{{ route('search-document') }}" class="w-full relative">
                    <div class="relative flex items-center w-full">
                        <input name="keyword" value="{{ request()->keyword }}" autocomplete="off"
                            aria-label="Tìm kiếm tài liệu"
                            class="w-full h-12 pl-5 pr-12 rounded-full border border-gray-300 focus:border-primary focus:outline-none"
                            type="text" placeholder="Tìm kiếm tài liệu">

                        <button type="submit" aria-label="Tìm kiếm"
                            class="absolute right-4 text-gray-500 hover:text-primary transition-colors p-3">
                            @svg('search', 'h-5 w-5')
                        </button>
                    </div>
                </form>
            </div>

            <!-- Right Side: Auth buttons / Menu Toggle -->
            <div class="flex items-center space-x-3">
                @auth
                    <!-- User Menu (Desktop + Mobile) -->
                    <div class="relative" x-data="{ openUserPopup: false }">
                        <button @click="openUserPopup = !openUserPopup" @click.outside="openUserPopup = false"
                            class="flex items-center space-x-2 focus:outline-none">
                            <div
                                class="h-10 w-10 rounded-full bg-primary text-white flex items-center justify-center overflow-hidden">
                                @if (auth()->user()->avatar)
                                    <img src="{{ auth()->user()->avatar }}" alt="avatar"
                                        class="h-full w-full object-cover">
                                @else
                                    <span class="text-lg font-semibold">{{ substr(auth()->user()->name, 0, 1) }}</span>
                                @endif
                            </div>
                        </button>
                        <!-- User Dropdown Menu -->
                        <div x-cloak x-show="openUserPopup"
                            class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50 border border-gray-200">
                            @include('user.menu')
                        </div>
                    </div>
                @else
                    <!-- Auth Buttons (Desktop) -->
                    <div class="hidden md:flex items-center space-x-3">
                        <a target="_blank" rel="nofollow"
                            href="https://chat.zalo.me/?phone={{ str_replace(' ', '', config('app.phone_support')) }}"
                            class="px-5 py-2.5 text-sm rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors font-bold">
                            Hỗ trợ ngay
                        </a>
                    </div>

                    <!-- Mobile Menu Toggle -->
                    <button class="block md:hidden cursor-pointer" aria-label="Mở menu" @click="open_list_mobile = !open_list_mobile">
                        @svg('queue-list', 'h-7 w-7 text-primary')
                    </button>
                @endauth
            </div>
        </div>

        <!-- Mobile Search Bar (Slide Down) -->
        <div x-cloak x-show="open_search_mobile" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4" class="md:hidden py-3">
            <form method="GET" action="{{ route('search-document') }}" class="w-full">
                <div class="relative flex items-center" @click.outside="open_search_mobile = false">
                    <input name="keyword" value="{{ request()->keyword }}" autocomplete="off"
                        aria-label="Tìm kiếm tài liệu"
                        class="w-full h-11 pl-4 pr-10 rounded-lg border border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 focus:ring-opacity-50 bg-gray-50"
                        type="text" placeholder="Tìm kiếm tài liệu">
                    <button type="submit" aria-label="Tìm kiếm"
                        class="absolute right-3 text-gray-500 hover:text-primary transition-colors">
                        @svg('search', 'h-5 w-5')
                    </button>
                </div>
            </form>
        </div>

        <!-- Mobile Menu (Slide Down) -->
        <div x-cloak x-show="open_list_mobile" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 transform -translate-y-4"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform -translate-y-4" class="md:hidden py-4 border-t border-gray-200"
            @click.outside="open_list_mobile = false">
            <div class="flex flex-col space-y-3">
                <a target="_blank" rel="nofollow"
                    href="https://chat.zalo.me/?phone={{ str_replace(' ', '', config('app.phone_support')) }}"
                    class="w-full py-2.5 text-center text-sm rounded-lg bg-primary text-white hover:bg-primary/90 transition-colors font-bold">
                    Hỗ trợ ngay
                </a>
            </div>
        </div>
    </div>
</header>
