<?php

namespace App\Manager\PageData\Legal\Settings\Invite;

use App\Core\Entities\Invite\Invite;
use App\Core\Entities\Invite\InviteForWho;
use App\Core\Entities\Invite\InviteTab;
use App\Core\Entities\User\Legal\Legal;
use App\Manager\Helpers\InviteHelper;
use App\Manager\Http\Requests\InviteSearchRequest;
use Illuminate\Support\Facades\DB;

class InvitePageData
{
    public function __construct(
        private InviteSearcher $inviteSearcher
    )
    {
    }

    public function build(Legal $legal, InviteSearchRequest $request): array
    {
        return [
            'tabs' => InviteHelper::getTabs(),
            'counts' => $this->getCounts($legal),
            'invites' => $this->inviteSearcher->search($legal, $request),
        ];
    }

    private function getCounts(Legal $legal): array
    {
        $inviteTable = Invite::getTableName();

        $tabInbox = InviteTab::INBOX;
        $tabOutbox = InviteTab::OUTBOX;
        $tabActive = InviteTab::ACTIVE;
        $tabComplete = InviteTab::COMPLETE;

        $inboxStatus = InviteHelper::getStatusByTab($tabInbox);
        $outboxStatus = InviteHelper::getStatusByTab($tabOutbox);
        $activeStatus = InviteHelper::getStatusByTab($tabActive);
        $completeStatus = InviteHelper::getStatusByTab($tabComplete);

        $sql = "
            WITH counts AS (
                SELECT
                    COUNT(*) FILTER (WHERE status = :inbox_status AND \"for\" = :for_legal) AS inbox,
                    COUNT(*) FILTER (WHERE status = :outbox_status AND \"for\" = :for_phys) AS outbox,
                    COUNT(*) FILTER (WHERE status = :active_status) AS active,
                    COUNT(*) FILTER (WHERE status = :complete_status) AS complete
                FROM {$inviteTable}
                WHERE legal_id = :legal_id
            )
            SELECT :tabInbox AS id, inbox AS cnt FROM counts
            UNION ALL
            SELECT :tabOutbox, outbox FROM counts
            UNION ALL
            SELECT :tabActive, active FROM counts
            UNION ALL
            SELECT :tabComplete, complete FROM counts
        ";

        $parameters = [
            'tabInbox' => $tabInbox->value,
            'tabOutbox' => $tabOutbox->value,
            'tabActive' => $tabActive->value,
            'tabComplete' => $tabComplete->value,
            'legal_id' => $legal->id,
            'inbox_status' => $inboxStatus->value,
            'outbox_status' => $outboxStatus->value,
            'active_status' => $activeStatus->value,
            'complete_status' => $completeStatus->value,
            'for_legal' => InviteForWho::LEGAL->value,
            'for_phys' => InviteForWho::PHYS->value,
        ];

        $rows = DB::select($sql, $parameters);

        $counts = [];

        foreach ($rows as $row) {
            $counts[$row->id] = $row->cnt;
        }

        return $counts;
    }
}
