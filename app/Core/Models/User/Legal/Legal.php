<?php

namespace App\Core\Models\User\Legal;

use App\Core\Models\LegalType;
use App\Core\Models\User\Legal\Dto\Company;
use App\Core\Models\User\Role;
use App\Core\Models\User\User;
use App\Core\Models\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Database\Factories\Core\Models\User\Legal\LegalFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

/**
 * @property LegalProfile $profile
 * @property LegalPayment $payment
 * @property LegalMail $mail
 * @property LegalWhatsApp $whatsApp
 *
 * @method static LegalFactory factory()
 */
class Legal extends User
{
    /**
     * @param Email $email
     * @param Password $password
     * @return self
     *
     * Тесты @see \Tests\Unit\Core\Models\User\Legal\CreateTest
     */
    public static function createNew(Email $email, Password $password): self
    {
        $user = parent::create([
            'username' => $email->getValue(),
            'email' => $email->getValue(),
            'password' => $password->getValue(),
            'role' => Role::LEGAL->value,
            'email_verify_token' => Str::random(60),
        ]);

        LegalProfile::create(['id' => $user->id]);
        LegalPayment::create(['id' => $user->id]);
        LegalMail::create(['id' => $user->id]);
        LegalWhatsApp::create(['id' => $user->id]);

        return $user;
    }

    public function getName(): string
    {
        return ! empty($this->profile->short_name)
            ? $this->profile->short_name
            : $this->username;
    }

    public function updateCompany(LegalType $type, Company $company): void
    {
        $profile = $this->profile;
        $profile->updateCompany($type, $company);
        $profile->saveOrFail();
    }

    /*******************************************************/

    protected static function booted(): void
    {
        static::addGlobalScope('legal_role', function (Builder $builder) {
            $builder->where('role', Role::LEGAL->value);
        });
    }

    public function profile(): HasOne|LegalProfile
    {
        return $this->hasOne(LegalProfile::class, 'id', 'id');
    }

    public function payment(): HasOne|LegalPayment
    {
        return $this->hasOne(LegalPayment::class, 'id', 'id');
    }

    public function mail(): HasOne|LegalMail
    {
        return $this->hasOne(LegalMail::class, 'id', 'id');
    }

    public function whatsApp(): HasOne|LegalWhatsApp
    {
        return $this->hasOne(LegalWhatsApp::class, 'id', 'id');
    }
}
