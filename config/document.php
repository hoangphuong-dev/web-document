<?php
return [
    'validator'       => [
        'default'    => [
            'min_page'      => env('DOCUMENT_VALIDATOR_MIN_PAGE', 0),
            'min_words'     => env('DOCUMENT_VALIDATOR_MIN_WORDS', 0),
            'min_chars'     => env('DOCUMENT_VALIDATOR_MIN_CHARS', 0),
            'lang'          => explode(',', env('DOCUMENT_VALIDATOR_LANG', '*')),
            'extensions'    => explode(',', env('DOCUMENT_VALIDATOR_EXTENSIONS', 'pdf,doc,docx,ppt,pptx')),
            'max_size'      => env('DOCUMENT_VALIDATOR_MAX_SIZE', 50), //MB
            'min_size'      => env('DOCUMENT_VALIDATOR_MIN_SIZE', 0.005), //MB
            'attachment'    => [
                'max_size' => env('DOCUMENT_VALIDATOR_ATTACHMENT_MAX_SIZE', 32), //MB
                'max_name' => env('DOCUMENT_VALIDATOR_ATTACHMENT_MAX_NAME', 50),
            ],
            'sale_document' => [
                'max_price' => env('DOCUMENT_VALIDATOR_SALE_DOCUMENT_MAX_PRICE', 500000),
                'min_price' => env('DOCUMENT_VALIDATOR_SALE_DOCUMENT_MIN_PRICE', 2000),
            ],
        ],
        // 'hash_check' => [
        //     'enabled'              => env('DOCUMENT_HASH_CHECK_ENABLED', true),
        //     'upload_check'         => env('DOCUMENT_HASH_CHECK_UPLOAD_CHECK', true),
        //     'hash_word_max_length' => env('DOCUMENT_HASH_CHECK_HASH_WORD_MAX_LENGTH', 5000),
        //     'similar'              => [
        //         'min_hash'    => env('DOCUMENT_HASH_CHECK_SIMILAR_MIN_HASH', 45), // 50 câu văn
        //         'min_match'   => env('DOCUMENT_HASH_CHECK_SIMILAR_MIN_MATCH', 30),
        //         'min_accept'  => env('DOCUMENT_HASH_CHECK_SIMILAR_MIN_ACCEPT', 80), //%
        //         'min_suggest' => env('DOCUMENT_HASH_CHECK_SIMILAR_MIN_SUGGEST', 70), //%
        //     ],
        // ],
    ],
    'html'            => [
        'min_page'     => env('DOCUMENT_HTML_MIN_PAGE', 20),
        'max_page'     => env('DOCUMENT_HTML_MAX_PAGE', 40),
        'percent_page' => env('DOCUMENT_HTML_MAX_PAGE', 0.5),
        'min_length'   => env('DOCUMENT_HTML_MIN_LENGTH', 15000),
    ],
    'preview'         => [
        'page_per_part' => env('DOCUMENT_PREVIEW_PAGE_PER_PART', 3),
    ],
    'id_split'        => [
        'data1_data2' => env('DOCUMENT_ID_SPLIT_DATA1_DATA2', 2307556),
        'data2_data3' => env('DOCUMENT_ID_SPLIT_DATA2_DATA3', 4311846),
        'data3_data4' => env('DOCUMENT_ID_SPLIT_DATA3_DATA4', 6414759),
        'data4_data5' => env('DOCUMENT_ID_SPLIT_DATA4_DATA5', 7758777),
        'data5_data6' => env('DOCUMENT_ID_SPLIT_DATA5_DATA6', 10082560),
    ],
    'prices'          => explode(
        ',',
        env('DOCUMENT_PRICES', '2000, 3000, 4000, 5000, 7000, 10000, 14000, 15000, 20000, 37000, 38000, 50000, 77000, 100000,500000')
    ),
    //cat thu tiền
    'sale_categories' => explode(',', env(
        'DOCUMENT_SALE_CATEGORIES',
        '170, 171, 172, 173, 174, 175, 176, 177, 178, 179, 180, 181, 182, 183, 184, 185, 282, 283, 36, 37, 38, 39, 40, 41, 42, 43'
    )),
];
