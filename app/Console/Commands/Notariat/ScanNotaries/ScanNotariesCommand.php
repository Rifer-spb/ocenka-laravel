<?php

namespace App\Console\Commands\Notariat\ScanNotaries;

use App\Core\Models\Notariat\Notariat;
use App\Core\Validators\RequestValidator;
use Illuminate\Console\Command;

class ScanNotariesCommand extends Command
{
    protected $signature = 'notariat:scan';
    private Notariat $notariat;

    /**
     * @throws \Throwable
     */
    public function handle(): int
    {
        $this->notariat = Notariat::current();
        $parseUrl = $this->notariat->getCurrentNotaryUrl();
        $currentNotariatId = $this->notariat->current_notary_scan_id;

        if (!RequestValidator::isResponseCode($parseUrl, 200)) {
            $this->notariat->incrementCurrentNotaryScanId();
            $this->warn("Пропущен ID {$currentNotariatId}, невалидный ответ.");
            return self::SUCCESS;
        }

        try {
            $result = ResourceContentParser::parse($parseUrl);

            if ($result !== null && $result->isReadyForInsertToDb()) {
                NotaryCreator::createOrUpdate($currentNotariatId, $result);
                $this->info("✓ Нотариус (NotariatNotaryID={$currentNotariatId}) сохранён: {$result->name}");
            } else {
                $this->warn("Данные для NotariatNotaryID={$currentNotariatId} неполные, пропущен.");
            }
        } catch (\Throwable $e) {
            report($e);

            $this->error("Ошибка при обработке NotariatNotaryID={$currentNotariatId}: {$e->getMessage()}");
        }

        $this->notariat->incrementCurrentNotaryScanId();

        return self::SUCCESS;
    }
}
