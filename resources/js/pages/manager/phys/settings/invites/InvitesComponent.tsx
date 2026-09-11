import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { useManagerRoute } from '@/hooks/useManagerRoute';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@/components/app/manager/legal/inviteTabs/types";

type Props = {
    invites: IInviteItem[];
    currentTab: IInviteTab;
}

export default function({ invites, currentTab } : Props) {
    const route = useManagerRoute();

    const handleReSend = (id: number) => {
        router.post(route(`settings/legals/re-send/${id}`));
    };

    const handleCancel = (id: number) => {
        router.post(route(`settings/legals/cancel/${id}`));
    };

    const handleConfirm = (id: number) => {
        router.post(route(`settings/legals/confirm/${id}`));
    };

    return (
        <div className="invites">
            {invites.length
                ? <div className="table">
                    <div className="tr">
                        <div className="th date">Дата</div>
                        <div className="th name">Юр. лицо</div>
                        <div className="th status">Статус</div>
                        <div className="th action">Действие</div>
                    </div>
                    {invites.map(invite => <InviteComponent
                        key={invite.id}
                        invite={invite}
                        currentTab={currentTab}
                        handleReSend={handleReSend}
                        handleCancel={handleCancel}
                        handleConfirm={handleConfirm}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
