<footer class="mt-auto bg-white shadow-md">
    <div class="container mx-auto max-w-screen-xl px-4 py-10 md:py-12">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 md:gap-10">
            <!-- Logo & About Section -->
            <div class="space-y-4 lg:col-span-1">
                <a href="{{ route('index') }}" class="block mb-3" aria-label="Trang chủ">
                    <span class="text-2xl text-primary font-bold">✨ KhoSangKien ✨</span>
                </a>
                <p class="text-base font-bold text-gray-800">Tổng hợp tài liệu chất lượng</p>
                <p class="text-sm text-gray-600 mt-2 pr-4">Kho tài liệu đa dạng, uy tín đáp ứng nhu cầu học tập và nghiên
                    cứu của bạn.</p>
            </div>

            <!-- Quick Links Section -->
            <div class="space-y-4">
                <p class="text-lg font-bold text-gray-800 pb-1 border-b border-gray-200 inline-block">Liên kết nhanh</p>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('index') }}"
                            class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Trang chủ
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Về chúng tôi
                        </a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Chính sách
                        </a>
                    </li>
                    <li>
                        <p onclick="Livewire.dispatch('openModal', { component: 'popup.login' })"
                            class="text-gray-600 hover:text-primary transition-colors flex items-center cursor-pointer">
                            <span class="mr-1.5">•</span> Đăng nhập
                        </p>
                    </li>
                </ul>
            </div>

            <!-- Reference Section -->
            <div class="space-y-4">
                <p class="text-lg font-bold text-gray-800 pb-1 border-b border-gray-200 inline-block">Danh mục nổi bật
                </p>
                <ul class="space-y-2">
                    <li>
                        <a href="https://khosangkien.com/danh-muc/sang-kien-thpt.c19"
                            class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Sáng kiến THPT
                        </a>
                    </li>
                    <li>
                        <a href="https://khosangkien.com/tag/phuong-phap-day-hoc.t19"
                            class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Phương pháp dạy học
                        </a>
                    </li>
                    <li>
                        <a href="https://khosangkien.com/chu-de/phuong-phap-giang-day.t8"
                            class="text-gray-600 hover:text-primary transition-colors flex items-center">
                            <span class="mr-1.5">•</span> Phương pháp giảng dạy
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Section -->
            <div class="space-y-4">
                <p class="text-lg font-bold text-gray-800 pb-1 border-b border-gray-200 inline-block">Liên hệ hỗ trợ</p>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <div class="mt-0.5 min-w-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#FA8072" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </div>
                        <span class="text-gray-600">{{ config('app.phone_support') }}</span>
                    </li>
                    <li class="flex items-start">
                        <div class="mt-0.5 min-w-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="#FA8072" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" />
                            </svg>
                        </div>
                        <span class="text-gray-600">admin@khosangkien.com</span>
                    </li>
                    <li>
                        <a class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/90 transition-colors"
                            target="_blank" rel="nofollow"
                            href="https://chat.zalo.me/?phone={{ str_replace(' ', '', config('app.phone_support')) }}">
                            <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24" fill="currentColor"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM16 13H13V16C13 16.55 12.55 17 12 17C11.45 17 11 16.55 11 16V13H8C7.45 13 7 12.55 7 12C7 11.45 7.45 11 8 11H11V8C11 7.45 11.45 7 12 7C12.55 7 13 7.45 13 8V11H16C16.55 11 17 11.45 17 12C17 12.55 16.55 13 16 13Z" />
                            </svg>
                            Chat Zalo
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-200 my-8"></div>

        <!-- Bottom Footer -->
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <!-- Copyright -->
            <p class="text-sm text-gray-500 order-2 md:order-1">
                Copyright © {{ date('Y') }}
                <a href="{{ config('app.url') }}" class="hover:underline text-gray-700 font-medium"
                    aria-label="Trang chủ">
                    {{ config('app.host') }}
                </a>
                - Tất cả quyền được bảo lưu
            </p>

            <!-- Social Media Links -->
            <div class="flex space-x-4 order-1 md:order-2">
                <a href="#" class="text-gray-500 hover:text-primary transition-colors" aria-label="Facebook">
                    <svg class="w-5 h-5" fill="#FA8072" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-primary transition-colors" aria-label="Twitter">
                    <svg class="w-5 h-5" fill="#FA8072" viewBox="0 0 24 24" aria-hidden="true">
                        <path
                            d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84">
                        </path>
                    </svg>
                </a>
                <a href="#" class="text-gray-500 hover:text-primary transition-colors" aria-label="Instagram">
                    <svg class="w-5 h-5" fill="#FA8072" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                            clip-rule="evenodd"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>
