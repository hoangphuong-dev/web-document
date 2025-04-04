@unless (empty($alerts))
    <div class="alert-container space-y-2" id="alert{{ $uuid }}">
        @foreach ($alerts as $alert)
            @switch($alert->type)
                @case('info')
                    <div class="flex items-center px-4 py-2 text-sm rounded-md !bg-light-info !text-info {{ $attributes->get('class') }}"
                        role="alert">
                        @svg('info-circle', 'mr-3 inline h-4 w-4 flex-shrink-0')
                        <span class="sr-only">{{ ucwords($alert->type) }}</span>
                        <div>
                            {!! $alert->message !!}
                        </div>
                    </div>
                @break

                @case('success')
                    <div class="flex items-center px-4 py-2 text-sm rounded-md !bg-light-success !text-success {{ $attributes->get('class') }}"
                        role="alert">
                        @svg('check-circle', 'mr-3 inline h-4 w-4 flex-shrink-0')
                        <span class="sr-only">{{ ucwords($alert->type) }}</span>
                        <div>
                            {!! $alert->message !!}
                        </div>
                    </div>
                @break

                @case('warning')
                    <div class="flex items-center px-4 py-2 text-sm rounded-md !bg-light-warning !text-warning {{ $attributes->get('class') }}"
                        role="alert">
                        @svg('warning', 'mr-3 inline h-4 w-4 flex-shrink-0')
                        <span class="sr-only">{{ ucwords($alert->type) }}</span>
                        <div>
                            {!! $alert->message !!}
                        </div>
                    </div>
                @break

                @case('error')
                    <div class="flex items-center px-4 py-2 text-sm rounded-md !bg-light-error !text-error {{ $attributes->get('class') }}"
                        role="alert">
                        @svg('x-circle', 'mr-3 inline h-4 w-4 flex-shrink-0')
                        <span class="sr-only">{{ ucwords($alert->type) }}</span>
                        <div>
                            {!! $alert->message !!}
                        </div>
                    </div>
                @break
            @endswitch
        @endforeach
    </div>

    @if ($autoClose)
        <script>
            setTimeout(function() {
                document.getElementById("alert{{ $uuid }}")?.remove();
            }, {{ $duration ?? 3000 }});
        </script>
    @endif
@endunless
