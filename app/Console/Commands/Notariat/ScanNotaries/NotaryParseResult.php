<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

use App\Core\Entities\Notary\NotaryRegion;

final readonly class NotaryParseResult
{
    public function __construct(
        public ?NotaryRegion $region,
        public bool $isNotWork,
        public ?string $name,
        public ?string $address,
        public array $phones,
        public array $emails,
        public ?string $site,
    ) {
    }

    public function isReadyForInsertToDb(): bool
    {
        return
            $this->region !== null
            && !empty($this->name)
            && !empty($this->address)
            && !empty($this->phones);
    }
}
