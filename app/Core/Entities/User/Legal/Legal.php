<?php

namespace App\Core\Entities\User\Legal;

use App\Core\Attributes\TestClass;
use App\Core\Entities\LegalType;
use App\Core\Entities\User\Legal\ValueObjects\Company;
use App\Core\Entities\User\Legal\ValueObjects\RegistryTemplate;
use App\Core\Entities\User\Role;
use App\Core\Entities\User\User;
use App\Core\Entities\User\ValueObjects\Password;
use App\Core\ValueObjects\Email;
use Database\Factories\Core\Entities\User\Legal\LegalFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use Tests\Unit\Core\Entities\User\Legal\CreateTest;
use Tests\Unit\Core\Entities\User\Legal\GetNameTest;
use Tests\Unit\Core\Entities\User\Legal\UpdateCompanyTest;

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
     * @throws \Throwable
     */
    #[TestClass(CreateTest::class)]
    public static function createNew(Email $email, Password $password): self
    {
        $user = new self();
        $user->username = $email->getValue();
        $user->email = $email->getValue();
        $user->password = $password->getValue();
        $user->role = Role::LEGAL->value;
        $user->email_verify_token = Str::random(60);
        $user->saveOrFail();

        $user->profile()->make()->saveOrFail();
        $user->payment()->make()->saveOrFail();
        $user->mail()->make()->saveOrFail();
        $user->whatsApp()->make()->saveOrFail();

        return $user;
    }

    #[TestClass(GetNameTest::class)]
    public function getName(): string
    {
        return ! empty($this->profile->short_name)
            ? $this->profile->short_name
            : $this->username;
    }

    /**
     * @throws \Throwable
     */
    #[TestClass(UpdateCompanyTest::class)]
    public function updateCompany(LegalType $type, Company $company): void
    {
        $profile = $this->profile;
        $profile->updateCompany($type, $company);
        $profile->saveOrFail();
    }

    /**
     * @throws \Throwable
     */
    public function updateRegistryTemplate(RegistryTemplate $template): void
    {
        $profile = $this->profile;
        $profile->registry_template = $template->getValue();
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
