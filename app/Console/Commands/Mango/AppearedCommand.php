<?php

namespace App\Console\Commands\Mango;

use App\Core\Entities\Call\MangoCallId;
use App\Core\Services\Mango\MangoService;
use App\Core\ValueObjects\NationalPhone;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class AppearedCommand extends Command
{
    protected $signature = 'mango:appeared';

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
        try {
            $this->service->appeared(
                new MangoCallId(Str::random(100)),
                new NationalPhone(79312311947),
                new NationalPhone(79312311947),
                CarbonImmutable::createFromTimestamp(time())
            );
        } catch (\Throwable $e) {
            $this->warn("⚠️ {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info('✅ Звонок добавлен');

        return self::SUCCESS;
    }
}
