<?php

return [

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
