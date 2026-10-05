<?php

namespace App\Core\Services;

use App\Core\Models\Notary\Notary;
use App\Core\ValueObjects\Site;
use Illuminate\Support\Facades\DB;

class NotaryService
{
    public function update(int $notaryId, array $emails, ?Site $site, ?bool $useDigitalReport, ?string $comment): void
    {
        $notary = Notary::findOrFail($notaryId);

        DB::transaction(function () use ($notary, $emails, $site, $useDigitalReport, $comment) {
            $notary->edit($emails, $site, $useDigitalReport, $comment);
            $notary->saveOrFail();
        });
    }
}
