<?php

$imageS3 = [
    'driver' => 's3',
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET', 'cdn-imgs-vndoc'),
    'url' => env('AWS_URL'),
    'endpoint' => env('AWS_ENDPOINT'),
    'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
    'throw' => false,
];

$documentS3 = $imageS3;
$documentS3['bucket'] = env('AWS_BUCKET_FILE', 'doc-storage-vndoc');


return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root'   => storage_path('app'),
            'throw'  => false,
        ],

        'public' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public'),
            'url'        => env('APP_URL') . 'storage',
            'visibility' => 'public',
            'throw'      => false,
        ],

        // Lưu file thumbnail document
        'thumbnail' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/thumbnail'),
            'url'        => env('APP_URL') . 'storage/thumbnail',
            'visibility' => 'public',
            'throw'      => false,
        ],

        'original' => [
            'driver'     => 'local',
            'root'       => storage_path('app/original'),
            'url'        => env('APP_URL') . 'storage',
            'visibility' => 'public',
            'throw'      => false,
        ],

        'sitemap' => [
            'driver'     => 'local',
            'root'       => storage_path('app/public/sitemaps'),
            'url'        => env('APP_URL') . '/sitemaps',
            'visibility' => 'public',
            'throw'      => false,
        ],

        's3_file'    => $imageS3,
        's3_document' => $documentS3,

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
