<?php use Hewalex\Client\Client as HewalexClient;

return [
    'client_name' => [
        'url' => 'https://api.example.url',
        'endpoints' => [
            'user' => 'user/',
            'item' => 'item/',
        ],
        'secret' => 'somesuperrandomstring',
        'timeout' => 10,
        'stats' => false,
        'debug' => HewalexClient::DEBUG_OFF,
        'user_agent' => 'Example Client', // who use this client
        'load_content' => true, // loads content to the memory if set true. Is
        // 'ssl' => 'path_to_file_or_directory',
        'debug'   => [
                    \Hewalex\Client\Client::STATUS_BAD_REQUEST           => \Hewalex\Client\Client::DEBUG_LOG_AND_THROW_EXCEPTION,
                    \Hewalex\Client\Client::STATUS_FORBIDDEN             => \Hewalex\Client\Client::DEBUG_LOG_AND_THROW_EXCEPTION,
                    \Hewalex\Client\Client::STATUS_NOT_FOUND             => \Hewalex\Client\Client::DEBUG_LOG_AND_THROW_EXCEPTION,
                    \Hewalex\Client\Client::STATUS_INTERNAL_SERVER_ERROR => \Hewalex\Client\Client::DEBUG_LOG_AND_THROW_EXCEPTION,
                ],
    ],
];