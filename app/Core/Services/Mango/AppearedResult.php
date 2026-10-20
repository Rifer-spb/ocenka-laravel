<?php

namespace App\Core\Services\Mango;

enum AppearedResult: string
{
    case Ok = 'ok';
    case AlreadyExists = 'already_exists';
    case LegalNotFound = 'legal_not_found';
    case NoEmployees = 'no_employees';
}
