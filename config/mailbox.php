<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Storage Disk
    |--------------------------------------------------------------------------
    |
    | This value defines the disk where emails and attachments are stored.
    | If not specified, the default filesystem disk will be used.
    |
    | Supported: Any disk configured in config/filesystems.php
    | Examples: "local", "s3", "ses", "minio"
    |
    */

    'disk' => env('MAILBOX_STORAGE_DISK'),

    /*
    |--------------------------------------------------------------------------
    | Storage Path
    |--------------------------------------------------------------------------
    |
    | This value defines the path where emails and attachments will be stored.
    | The path is relative to the configured disk.
    |
    */

    'path' => env('MAILBOX_STORAGE_PATH', 'mailbox'),

    /*
    |--------------------------------------------------------------------------
    | Extraction Rules
    |--------------------------------------------------------------------------
    |
    | An array of classes implementing the Extractor interface. Each class
    | defines matching and processing logic for extracting data from emails.
    |
    */

    'extraction_rules' => [
        // \App\Extractors\ExampleExtractor::class,
    ],

];
