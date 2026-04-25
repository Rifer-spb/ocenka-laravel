<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $for
 * @property int $status
 * @property bool $is_manager
 * @property int $work_rate
 * @property string $created_at
 * @property string $rejected_at
 * @property string $fired_at
 */
class LegalEmployee extends AbstractEntity
{

}
