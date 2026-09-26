<?php

namespace App\Manager\UseCases\Legal\Registry;

use App\Core\Models\User\Legal\Legal;
use App\Core\Models\User\Legal\ValueObjects\RegistryTemplate;

class UpdateTemplateUseCase
{
    public function execute(Legal $legal, RegistryTemplate $template): void
    {
        $legal->updateRegistryTemplate($template);
    }
}
