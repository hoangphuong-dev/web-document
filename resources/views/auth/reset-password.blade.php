@extends('layouts.app')

@section('content')
    <div class="mx-auto my-20 w-full max-w-xl">
        <div class="rounded border bg-white p-4 md:p-10 md:shadow-lg">
            <div class="flex flex-col items-center">
                <span class="mt-2 text-2xl leading-normal font-semi-bold">Đặt lại mật khẩu?</span>
            </div>

            <div class="my-8">
                <div class="my-2 flex cursor-pointer items-center rounded-md border px-4 py-2">
                    {{-- <img class="w-12 rounded-md border" src="{{ ImageHelper::getImageDefault('user') }}" alt="avatar" /> --}}
                    <div class="ml-3 overflow-hidden">
                        <p class="truncate" id="message">Đặt lại mật khẩu cho tài khoản</p>
                        <p class="truncate font-bold">{{ $request->email }}</p>
                    </div>
                </div>
            </div>

            <livewire:auth.reset-password :token="$request->token" :email="$request->email"></livewire:auth.reset-password>
        </div>
    </div>
@endsection
