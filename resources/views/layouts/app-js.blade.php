@if (session()->has('notify'))
    <script type="module">
        setTimeout(function() {
            Livewire.dispatch('openModal', {
                component: 'popup.notification',
                arguments: {
                    'message': '{{ session()->get('notify') }}'
                }
            })
        }, 500);
    </script>
@endif

<script>
    try {
        const script = document.createElement('script');
        script.src = "{{ asset('js/lazyload.min.js') }}";
        script.type = 'module';
        script.async = true;
        script.onload = () => {
            window.lazyLoadOptions = {
                elements_selector: ".entry-content img"
            };
        };

        script.onerror = () => {
            console.error('Failed to load lazyload.min.js. Using fallback.');
        };

        document.head.appendChild(script);
    } catch (error) {
        console.error('Error initializing lazyload:', error);
    }
</script>
