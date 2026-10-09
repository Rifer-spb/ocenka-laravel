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
        public array $emails,
        public ?Site $site,
        public ?bool $useDigitalReport,
        public ?string $comment,
    ) {}
}
