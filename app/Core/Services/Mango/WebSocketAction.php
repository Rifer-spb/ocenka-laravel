<?php

namespace App\Core\Services\Mango;

enum WebSocketAction: string
{
    case add = 'add';
    case update = 'update';
    case delete = 'delete';
}
