@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="text-center mt-56 text-2xl">
            Website đang trong thời gian thử nghiệm. <br>
            Nếu tải tài liệu, bạn vui lòng nhắn zalo {{ config('app.phone_support') }} để được hỗ trợ tận tình. <br> hoặc
            <a class="text-primary underline" target="_blank" rel="nofollow"
                href="https://chat.zalo.me/?phone={{ str_replace(' ', '', config('app.phone_support')) }}"> Chat ngay</a>
        </h2>
    </div>
@endsection
