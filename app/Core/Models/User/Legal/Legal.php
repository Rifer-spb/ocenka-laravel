<?php

namespace App\Core\Models\User\Legal;

use App\Core\Models\Legal\LegalMail;
use App\Core\Models\Legal\LegalPayment;
use App\Core\Models\Legal\LegalProfile;
use App\Core\Models\Legal\LegalWhatsApp;
use App\Core\Models\User\User;

class Legal extends User
{
    public static function signUpManager(string $email, string $password, string $role): static
    {
        $user = parent::signUpManager($email, $password, $role);

        LegalProfile::create(['id' => $user->id]);
        LegalPayment::create(['id' => $user->id]);
        LegalMail::create(['id' => $user->id]);
        LegalWhatsApp::create(['id' => $user->id]);

        return $user;
    }
}
