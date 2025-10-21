<?php
return [
    'app_name' => 'MaxiStore',
    'env' => 'development',
    'debug' => true,
    'base_url' => 'http://localhost',
    'timezone' => 'Europe/Istanbul',
    'mail' => [
        'from_name' => 'MaxiStore',
        'from_email' => 'noreply@maxistore.local',
        'smtp_host' => '',
        'smtp_port' => 587,
        'smtp_user' => '',
        'smtp_password' => ''
    ],
    'security' => [
        'session_name' => 'maxistore_session',
        'csrf_ttl' => 7200,
        'password_reset_ttl' => 3600,
        'rate_limit' => [
            'login' => ['attempts' => 5, 'interval' => 900]
        ]
    ],
    'payment' => [
        'default_driver' => 'manual',
        'drivers' => [
            'manual' => [],
            'iyzico_mock' => [
                'api_key' => 'mock-key',
                'secret' => 'mock-secret'
            ],
            'papara_mock' => [
                'merchant_id' => 'mock-merchant'
            ]
        ]
    ]
];
