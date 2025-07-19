<?php

return [
    'host' => env('RABBITMQ_HOST', 'fraud-rabbitmq'),
    'port' => env('RABBITMQ_PORT', 5672),
    'user' => env('RABBITMQ_USER', 'fraud_user'),
    'password' => env('RABBITMQ_PASSWORD', 'fraud_password'),
];
