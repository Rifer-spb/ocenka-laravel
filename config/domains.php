<?php

return [
    'manager' => parse_url(env('APP_MANAGER_URL'), PHP_URL_HOST),
    'client'  => parse_url(env('APP_CLIENT_URL'), PHP_URL_HOST),
    'notary'  => parse_url(env('APP_NOTARY_URL'), PHP_URL_HOST),
];
