@if($clarity = config('app.clarity'))
    <script>
        // Đảm bảo `requestIdleCallback` khả dụng, fallback sang `setTimeout` nếu cần
        window.requestIdleCallback = window.requestIdleCallback || function (cb) { setTimeout(cb, 2000); };

        requestIdleCallback(function () {
            (function(c, l, a, r, i, t, y) {
                c[a] = c[a] || function() { (c[a].q = c[a].q || []).push(arguments) };
                t = l.createElement(r); 
                t.async = 1; 
                t.src = "https://www.clarity.ms/tag/" + i;
                y = l.getElementsByTagName(r)[0]; 
                y.parentNode.insertBefore(t, y);
            })(window, document, "clarity", "script", "{{ $clarity }}");
        });
    </script>
@endif
