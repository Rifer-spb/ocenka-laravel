<?php

namespace App\Core\Entities\Notary;

use App\Core\ValueObjects\Email;
use App\Core\ValueObjects\Site;

final readonly class NotaryUpdateData
{
    /**
     * @param Email[]|null $emails
     * @param Site|null $site
     * @param bool|null $useDigitalReport
     * @param string|null $comment
     */
    public function __construct(
        public ?array $emails = null,
        public ?Site $site = null,
        public ?bool $useDigitalReport = null,
        public ?string $comment = null,
    ) {}

    public function hasData(): bool
    {
        return
            $this->hasEmails()
            || $this->hasSite()
            || $this->hasUseDigitalReport()
            || $this->hasComment();
    }

    public function hasEmails(): bool
    {
        return $this->emails !== null;
    }

    public function hasSite(): bool
    {
        return $this->site !== null;
    }

    public function hasUseDigitalReport(): bool
    {
        return $this->useDigitalReport !== null;
    }

    public function hasComment(): bool
    {
        return $this->comment !== null;
    }
}
