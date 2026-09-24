<?php

namespace App\Manager\UseCases\Phys\Notary;

use App\Core\Models\Notary\Notary;
use App\Core\ValueObjects\Site;
use Illuminate\Support\Facades\DB;

class UpdateUseCase
{
    /**
     * @param int $notaryId
     * @param array $emails
     * @param null|Site $site
     * @param bool|null $useDigitalReport
     * @param null|string $comment
     * @return void
     * @throws \Throwable
     */
    public function execute(int $notaryId, array $emails, ?Site $site, ?bool $useDigitalReport, ?string $comment): void
    {
        DB::transaction(function () use ($notaryId, $emails, $site, $useDigitalReport, $comment) {
            $notary = Notary::findOrFail($notaryId);
            $notary->edit($emails, $site, $useDigitalReport, $comment);
            $notary->saveOrFail();
        });
    }
}
