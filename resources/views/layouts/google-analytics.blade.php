@if ($analytics = config('app.gg_analytics'))
    <script>
        // Đảm bảo `requestIdleCallback` khả dụng, fallback sang `setTimeout` nếu cần
        window.requestIdleCallback = window.requestIdleCallback || function (cb) { setTimeout(cb, 2000); };

        requestIdleCallback(function () {
            // Tạo script để tải Google Tag Manager
            const script = document.createElement('script');
            script.async = true;
            script.src = "https://www.googletagmanager.com/gtag/js?id={{ $analytics }}";
            
            // Đặt thuộc tính nonce nếu có Content Security Policy (CSP) để tăng cường bảo mật
            @if (config('app.csp_nonce'))
                script.nonce = "{{ config('app.csp_nonce') }}";
            @endif

            // Gắn script vào <head> để bắt đầu tải
            document.head.appendChild(script);

            // Khởi tạo Google Analytics sau khi script được tải
            script.onload = function () {
                window.dataLayer = window.dataLayer || [];
                function gtag() {
                    dataLayer.push(arguments);
                }
                gtag('js', new Date());
                gtag('config', '{{ $analytics }}', {
                    // Chỉ gửi pageview khi cần thiết để giảm tải không cần thiết
                    send_page_view: false,
                });

                // Gửi pageview thủ công nếu cần
                @if (isset($page_view_event))
                    gtag('event', 'page_view', {!! json_encode($page_view_event) !!});
                @endif
            };
        });
    </script>
@endif
