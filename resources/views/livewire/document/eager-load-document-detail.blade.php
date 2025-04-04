<div>
    @if ($type == App\Enums\Document\EagerLoadScene::PREVIEW)
        <div class="relative document-preview-container">
            @if ($urlPreview)
                <div class="iframe-container">
                    <iframe width="100%" height="600" class="border-0 w-full h-[600px] md:h-[800px] lg:h-[1100px]"
                        scrolling="auto" src="{{ route('document.view', ['file' => $urlPreview]) }}">
                    </iframe>
                </div>
                <div class="absolute inset-0 pointer-events-none flex items-center justify-center opacity-10">
                    <div class="transform rotate-45 text-gray-500 text-4xl font-bold">
                        BẢN XEM TRƯỚC
                    </div>
                </div>
            @else
                <div class="w-full p-6 flex flex-col items-center justify-center bg-gray-50">
                    <img width="300" height="500" src="{{ ImageHelper::getImageDefault('doc') }}"
                        alt="{{ $document->title }}"
                        class="max-w-full object-cover min-w-[250px] w-auto mb-4 shadow-md rounded">
                    <p class="text-gray-500 text-center mt-4">Xem trước không khả dụng</p>
                </div>
            @endif
        </div>
    @endif

    @push('scripts')
        <script type="module">
            let init = false;
            const handleEagerLoad = () => {
                if (!init) {
                    init = true;
                    Livewire.dispatch('eagerLoad');
                }
            };
            window.addEventListener("scroll", handleEagerLoad);
            window.addEventListener("mousemove", handleEagerLoad);

            // Add zoom control functionality
            document.addEventListener('DOMContentLoaded', function() {
                const zoomInBtn = document.querySelector('button[title="Phóng to"]');
                const zoomOutBtn = document.querySelector('button[title="Thu nhỏ"]');
                const iframe = document.querySelector('iframe');

                if (zoomInBtn && zoomOutBtn && iframe) {
                    let scale = 1;

                    zoomInBtn.addEventListener('click', function() {
                        scale += 0.1;
                        updateZoom();
                    });

                    zoomOutBtn.addEventListener('click', function() {
                        if (scale > 0.5) {
                            scale -= 0.1;
                            updateZoom();
                        }
                    });

                    function updateZoom() {
                        if (iframe.contentDocument && iframe.contentDocument.body) {
                            iframe.contentDocument.body.style.transform = `scale(${scale})`;
                            iframe.contentDocument.body.style.transformOrigin = 'top center';
                        }
                    }
                }
            });
        </script>
    @endpush
</div>
