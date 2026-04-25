<?php

namespace App\Core\Models\Legal;

use App\Core\Models\AbstractEntity;

/**
 * @property int $id
 * @property int $legal_id
 * @property int $phys_id
 * @property int $for
 * @property int $status
 * @property string $created_at
 * @property string $refused_at
 * @property string $rejected_at
 * @property string $fired_at
 * @property bool $is_manager
 * @property int $work_rate
 */
class LegalEmployee extends AbstractEntity
{

}
