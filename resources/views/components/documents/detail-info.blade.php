@if (!empty($docMetaData?->ai_cover))
    <h2 class="hidden">
        Thông tin về {{ $docMetaData->ai_title ?? $document->title }}
    </h2>
    @foreach ($document->listCover() as $key => $value)
        <h4 class="hidden">
            {{ $key }}: {{ is_array($value) ? str_to_array($value) : $value }}
        </h4>
    @endforeach
@endif
