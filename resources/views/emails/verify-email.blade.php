<x-mail::message>
# Xác thực tài khoản

Bạn cần xác thực tài khoản bằng cách nhấn vào nút xác thực bên dưới.

<x-mail::button :url="$verifyUrl">
    Xác thực tài khoản
</x-mail::button>

Bạn không thể bấm được nút ở trên? Hãy sao chép và dán đường link phía duới vào trình duyệt của bạn:

{{ $verifyUrl }}

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
