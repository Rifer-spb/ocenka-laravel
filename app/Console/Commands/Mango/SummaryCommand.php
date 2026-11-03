<?php

namespace App\Console\Commands\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Services\Mango\MangoCallStatus;
use App\Core\Services\Mango\MangoService;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class SummaryCommand extends Command
{
    protected $signature = 'mango:summary';

    public function __construct(
        private MangoService $service,
    ) {
        parent::__construct();
    }

    /**
     * @throws \Throwable
     */
    public function handle(): int
    {
        $call = Call::orderByDesc('id')->first();

        try {
            $this->service->summary(
                new MangoCallId($call->mango_call_id),
                new MangoCallStatus(1),
                CarbonImmutable::createFromTimestamp(time())
            );
        } catch (\Throwable $e) {
            $this->warn("⚠️ {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info('✅ Звонок успешно завершен');

        return self::SUCCESS;
    }
}
