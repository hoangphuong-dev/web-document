@extends('layouts.app')
@vite('resources/js/echo.js')
@push('scripts')
    {{-- <script type="module">
    window.Echo.channel('UserGuest')
        .listen('.PaymentSuccessNotLogin', (event) => {
            console.log('Echo connected', event);
                Livewire.dispatch('openModal', {
                    component: 'popup.notification',
                    arguments: {
                        'message': event.data
                    }
                })
        });
    </script> --}}

    <script type="module">
        @php
            $guestId = \Illuminate\Support\Facades\Cookie::get('is_guest');
        @endphp

        console.log('Echo INIT', window.Echo);
        console.log('guest_id', '{{ $guestId }}');
        @if ($guestId && \App\Services\System\GuestIdService::decodeGuestId($guestId))
            Echo.channel('App.Models.UserGuest.{{ $guestId }}')
                .listen('.PaymentNotEnoughNotLogin', (event) => {
                    console.log('Echo connected', event);
                    Livewire.dispatch('openModal', {
                        component: 'popup.notification',
                        arguments: {
                            'message': event.message
                        }
                    })
                })
                .listen('.PaymentSuccessNotLogin', (event) => {
                    console.log('Echo connected', event);
                    Livewire.dispatch('openModal', {
                        component: 'popup.payment.payment-sucess-not-login',
                        arguments: {
                            'data': event.data
                        }
                    })
                });
        @endif
    </script>
@endpush
@section('content')
    @php $moneyNeed = App\Services\Payment\PaymentNotLoginService::getMoneyNeed($document); @endphp
    <div class="container max-w-screen-xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-center mb-4">Thanh toán tài liệu</h1>
            <!-- Progress Steps -->
            <div class="flex justify-center items-center mb-4">
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-primary text-white">1</div>
                    <div class="mx-2 text-primary font-medium">Thông tin</div>
                </div>
                <div class="w-12 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600">2</div>
                    <div class="mx-2 text-gray-600">Thanh toán</div>
                </div>
                <div class="w-12 h-1 bg-gray-300 mx-2"></div>
                <div class="flex items-center">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-600">3</div>
                    <div class="mx-2 text-gray-600">Tải tài liệu</div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex flex-col-reverse md:flex-row md:gap-8">
            <!-- Customer Information Section -->
            <div class="md:w-5/12 mb-8 bg-white rounded-lg shadow-sm">
                <div class="p-4 md:p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Thông tin khách hàng
                    </h2>
                    @livewire('document.checkout-not-login', ['documentId' => $document->id])
                </div>
            </div>

            <!-- Document Information Section -->
            <div class="md:w-7/12 mb-8 bg-white rounded-lg shadow-sm">
                <div class="p-4 md:p-6">
                    <h2 class="text-xl font-bold mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-primary" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Thông tin tài liệu
                    </h2>

                    <!-- Document Preview Card -->
                    <div class="bg-gray-50 rounded-lg p-4 mb-6">
                        @php $documents = collect(['document' => $document]) @endphp
                        <x-documents.document-item-line :documents="$documents" :hiddenDesc="true" />
                    </div>

                    <!-- Order Summary -->
                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium mb-4">Tổng thanh toán</h3>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Giá tài liệu:</span>
                            <span class="font-bold">{{ Formatter::numberFormatVn($moneyNeed) }}</span>
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">Tổng cộng:</span>
                                <span
                                    class="text-xl font-bold text-primary">{{ Formatter::numberFormatVn($moneyNeed) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Security Badges -->
                    <div class="mt-6 flex flex-wrap justify-center gap-4 text-xs text-gray-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Thanh toán bảo mật
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Xử lý tức thì
                        </div>
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1 text-green-500" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                            Tải về ngay
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
