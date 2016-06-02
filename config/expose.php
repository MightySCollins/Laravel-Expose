<?php

return [
    'cache' => storage_path('expose'),

    'logFile' => storage_path('logs/expose.log'),

    'ignore' => ['password', '_token'],

    'mail' => [
        'to' => '',
        'from' => ''
    ]
];
