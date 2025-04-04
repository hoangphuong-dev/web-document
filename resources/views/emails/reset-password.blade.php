<x-mail::message>
# Đặt lại mật khẩu

Vui lòng nhấn nút đặt lại mật khẩu bên dưới, chúng tôi sẽ giúp bạn lấy lại mật khẩu.

<x-mail::button :url="$resetUrl">
    Đặt lại mật khẩu
</x-mail::button>

Bạn không thể bấm được nút ở trên? Hãy sao chép và dán đường link phía duới vào trình duyệt của bạn:

{{ $resetUrl }}

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
