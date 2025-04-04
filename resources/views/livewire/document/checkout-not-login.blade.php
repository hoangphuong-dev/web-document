<div>
    <x-alert class="justify-center text-lg my-4" />
    @if (count($accountTransfer))
        <!-- Order Summary When Payment Processing -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <h3 class="font-medium text-blue-900">Thông tin đơn hàng</h3>
            </div>
            
            <div class="space-y-3 mb-4">
                <div class="flex items-center border-b border-blue-100 pb-2">
                    <span class="w-28 text-gray-600">Email:</span>
                    <span class="font-medium">{{ Arr::get($form, 'email') }}</span>
                </div>
                <div class="flex items-center border-b border-blue-100 pb-2">
                    <span class="w-28 text-gray-600">Số điện thoại:</span>
                    <span class="font-medium">{{ Arr::get($form, 'phone') }}</span>
                </div>
                <div class="flex items-center border-b border-blue-100 pb-2">
                    <span class="w-28 text-gray-600">Phương thức:</span>
                    <span class="font-medium text-primary">Sepay</span>
                </div>
                <div class="flex items-center">
                    <span class="w-28 text-gray-600">Trạng thái:</span>
                    <span class="font-medium text-orange-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Chưa thanh toán
                    </span>
                </div>
            </div>
        </div>

        <!-- Payment Instructions Card -->
        <div class="border border-gray-200 rounded-lg shadow-sm overflow-hidden">
            <div class="bg-gray-50 px-4 py-3 border-b border-gray-200">
                <h2 class="font-bold text-gray-800 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Chuyển tiền bằng tài khoản ngân hàng hoặc ví điện tử
                </h2>
            </div>
            
            <div class="p-4">
                <!-- Instructions -->
                <div class="mb-6">
                    <ul class="space-y-3 text-sm text-gray-700">
                        <li class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span>Đăng nhập Internet Banking của ngân hàng và chuyển khoản theo thông tin sau:</span>
                        </li>
                        <li class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span>Vui lòng giữ nguyên nội dung chuyển khoản 
                                <span class="font-bold text-red-500">{{ Arr::get($accountTransfer, 'description') }}</span> 
                                và nhập đúng số tiền 
                                <span class="font-bold text-red-500">{{ Formatter::numberFormatVn(Arr::get($accountTransfer, 'money')) }}</span> 
                                để được xác nhận thanh toán trực tuyến.
                            </span>
                        </li>
                        <li class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Sau <span class="font-bold text-red-500">2 phút</span> chuyển khoản thành công, 
                                nếu không cập nhật trạng thái giao dịch. 
                                Quý khách vui lòng load trang và nhập lại thông tin để tải tài liệu
                            </span>
                        </li>
                        <li class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span>Nếu có lỗi xảy ra vui lòng liên hệ 
                                <a href="https://chat.zalo.me/?phone={{ str_replace(' ', '', config('app.phone_support')) }}" 
                                   target="_blank" rel="nofollow" 
                                   class="font-bold text-primary hover:underline">
                                    {{ config('app.phone_support') }}
                                </a> 
                                để được hỗ trợ tận tình.
                            </span>
                        </li>
                    </ul>
                </div>
                
                <!-- QR Code Section (Improved) -->
                <div class="flex flex-col items-center gap-6 my-6">
                    <!-- Larger QR Code Display -->
                    <div class="w-full max-w-xs mx-auto mb-4">
                        <div class="bg-white p-3 border-2 border-primary/20 rounded-lg shadow-md">
                            <img src="{{ Arr::get($accountTransfer, 'qr_link') }}" alt="QR Code" class="w-full h-auto">
                            <p class="text-sm text-center mt-3 text-gray-700 font-medium">Quét mã QR để thanh toán</p>
                        </div>
                    </div>
                    
                    <!-- Bank Information (Rearranged) -->
                    <div class="w-full bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <h4 class="font-medium text-gray-700 mb-3 text-center">Thông tin chuyển khoản</h4>
                        <div class="space-y-3 text-sm">
                            <div class="flex flex-wrap border-b border-gray-200 pb-2">
                                <span class="w-28 text-gray-600">Ngân hàng:</span>
                                <span class="font-medium">{{ Arr::get($accountTransfer, 'bank') }}</span>
                            </div>
                            <div class="flex flex-wrap border-b border-gray-200 pb-2">
                                <span class="w-28 text-gray-600">Tên tài khoản:</span>
                                <span class="font-medium">{{ Arr::get($accountTransfer, 'name') }}</span>
                            </div>
                            <div class="flex flex-wrap border-b border-gray-200 pb-2">
                                <span class="w-28 text-gray-600">Số tiền:</span>
                                <span class="font-medium text-red-500">{{ Formatter::numberFormatVn(Arr::get($accountTransfer, 'money')) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Status Indicator -->
                <div class="my-6 text-center">
                    <div class="inline-flex items-center px-4 py-2 bg-blue-50 border border-blue-100 rounded-full">
                        <svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm font-medium">Đang chờ thanh toán...</span>
                    </div>
                    
                    <div class="mt-4">
                        <button type="button" onclick="window.location.reload()" class="text-primary hover:text-primary-dark text-sm inline-flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            Làm mới trạng thái
                        </button>
                    </div>
                </div>
            </div>
        </div>
        
        <p class="flex justify-end text-xs mt-4 text-gray-500">Phiên làm việc: {{ $guestId }}</p>
    @else
        <!-- Customer Information Form -->
        <form class="space-y-5" wire:submit.prevent="requestPayment">
            <!-- Email Field -->
            <div class="space-y-1">
                <label for="email" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    Email <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="email" 
                           wire:model.live="form.email"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary @error('form.email') border-red-500 @enderror"
                           name="email" 
                           id="email" 
                           placeholder="example@email.com" />
                </div>
                @error('form.email')
                    <span class="block whitespace-normal text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone Field -->
            <div class="space-y-1">
                <label for="phone" class="block text-sm font-medium text-gray-700 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Số điện thoại <span class="text-red-500 ml-1">*</span>
                </label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <input type="tel" 
                           wire:model.live="form.phone"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-primary focus:border-primary @error('form.phone') border-red-500 @enderror"
                           name="phone" 
                           id="phone" 
                           placeholder="0912345678" />
                </div>
                @error('form.phone')
                    <span class="block whitespace-normal text-xs text-red-500 mt-1">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- Form Info Note -->
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-xs text-yellow-800">
                            Điền đúng Email và Số điện thoại để nhận tài liệu và được hỗ trợ khi có lỗi
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Payment Method Selection -->
            <div class="pt-6">
                <h3 class="text-lg font-medium mb-4 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Phương thức thanh toán
                </h3>
                <div class="bg-white rounded-lg border border-gray-300 p-4 hover:border-primary transition-colors">
                    <div class="flex items-center space-x-3">
                        <input type="radio" class="form-radio h-5 w-5 text-primary focus:ring-primary" checked id="sepay">
                        <label class="flex flex-col cursor-pointer" for="sepay">
                            <span class="font-medium text-gray-900">Thanh toán trực tuyến với Sepay</span>
                            <span class="text-sm text-gray-500 mt-1">Quét QR Code để thanh toán qua tài khoản ngân hàng</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="pt-6">
                <button class="w-full flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-colors" type="submit">
                    <div wire:target='requestPayment' wire:loading class="mr-2">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                    <span class="uppercase">Tiến hành thanh toán</span>
                </button>
            </div>
        </form>
    @endif
</div>