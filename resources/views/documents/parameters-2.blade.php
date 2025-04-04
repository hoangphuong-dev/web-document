<div class="px-4 md:h-12 rounded bg-gray-100 h-10 flex items-center gap-1">
    @svg('money', 'h-4 w-4 inline-block mr-1')
    {{ Formatter::numberFormatVn($document->money_sale) }}
</div>

<div class="px-4 md:h-12 rounded bg-gray-100 h-10 flex items-center gap-1">
    @svg('document', 'h-4 w-4')
    {{ Formatter::humanReadable($document->number_page) }}
</div>
<div class="px-4 md:h-12 rounded bg-gray-100 h-10 flex items-center gap-1">
    @svg('eye', 'h-4 w-4')
    <span>{{ Formatter::humanReadable($document->number_view) }}</span>
</div>
<div class="px-4 md:h-12 rounded bg-gray-100 h-10 flex items-center gap-1">
    @svg('download', 'h-4 w-4')
    <span>{{ Formatter::humanReadable($document->number_download) }}</span>
</div>
