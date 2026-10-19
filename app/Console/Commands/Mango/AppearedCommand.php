<?php

namespace App\Console\Commands\Mango;

use App\Core\Services\Mango\AppearedResult;
use App\Core\Services\Mango\MangoService;
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
        $result = $this->service->appeared(
            Str::random(100),
            79312311947,
            79312311947,
            CarbonImmutable::createFromTimestamp(time())
        );

        match ($result) {
            AppearedResult::Ok => $this->info('✅ Звонок добавлен'),
            AppearedResult::AlreadyExists => $this->warn('⚠️ Звонок уже добавлен'),
            AppearedResult::LegalNotFound => $this->warn('⚠️ Юрлицо не найдено'),
            AppearedResult::NoEmployees => $this->warn('⚠️ Сотрудники не найдены'),
        };

        return self::SUCCESS;
    }
}
