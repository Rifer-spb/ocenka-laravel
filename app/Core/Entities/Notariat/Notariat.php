<?php

namespace App\Core\Entities\Notariat;

use App\Core\Entities\AbstractEntity;

/**
 * @property int $id
 * @property int $current_notary_scan_id текущий id сканирования нотариусов из data.notariat.ru
 */
class Notariat extends AbstractEntity
{
    protected $table = 'notariat';
    private const SINGLETON_ID = 1;
    private const DATA_NOTARY_URL = 'https://data.notariat.ru/directory/notary-data';
    private const MAX_CURRENT_NOTARY_SCAN = 16500;

    public static function current(): self
    {
        return self::findOrFail(self::SINGLETON_ID);
    }

    /**
     * @throws \Throwable
     */
    public function incrementCurrentNotaryScanId(): void
    {
        if ($this->current_notary_scan_id >= self::MAX_CURRENT_NOTARY_SCAN) {
            $this->current_notary_scan_id = 1;
            $this->saveOrFail();
            return;
        }

        $this->increment('current_notary_scan_id');
    }

    public function getCurrentNotaryUrl(): string
    {
        return implode('/', [self::DATA_NOTARY_URL, $this->current_notary_scan_id]);
    }
}
