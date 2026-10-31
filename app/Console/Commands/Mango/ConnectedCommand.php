<?php

namespace App\Console\Commands\Mango;

use App\Core\Entities\Call\Call;
use App\Core\Entities\Call\MangoCallId;
use App\Core\Entities\Employee\PhoneExtension;
use App\Core\Services\Mango\MangoService;
use Carbon\CarbonImmutable;
use Illuminate\Console\Command;

class ConnectedCommand extends Command
{
    protected $signature = 'mango:connected';

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
            $this->service->connected(
                new MangoCallId($call->mango_call_id),
                new PhoneExtension(101),
                CarbonImmutable::createFromTimestamp(time())
            );
        } catch (\Throwable $e) {
            $this->warn("⚠️ {$e->getMessage()}");

            return self::FAILURE;
        }

        $this->info('✅ Звонок успешно переведен в обработку');

        return self::SUCCESS;
    }
}
