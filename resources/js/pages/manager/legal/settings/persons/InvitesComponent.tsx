import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { useManagerRoute } from '@/hooks/useManagerRoute';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@/components/app/manager/legal/inviteTabs/types";

interface IProps {
    currentTab: IInviteTab
    invites: IInviteItem[];
}

export default function({ currentTab, invites } : IProps) {
    const route = useManagerRoute();

    const handleReSend = (id: number) => {
        router.post(route(`settings/persons/re-send/${id}`));
    };

    const handleCancel = (id: number) => {
        router.post(route(`settings/persons/cancel/${id}`));
    };

    const handleConfirm = (id: number) => {
        router.post(route(`settings/persons/confirm/${id}`));
    };

    const handleComplete = (id: number) => {
        router.post(route(`settings/persons/complete/${id}`));
    };

    return (
        <div className="invites">
            {invites.length
                ? <div className="table">
                    <div className="tr">
                        <div className="th date">Дата</div>
                        <div className="th name">Сотрудник</div>
                        <div className="th status">Статус</div>
                        <div className="th action">Действие</div>
                    </div>
                    {invites.map(invite => <InviteComponent
                        key={invite.id}
                        currentTab={currentTab}
                        invite={invite}
                        handleReSend={handleReSend}
                        handleCancel={handleCancel}
                        handleConfirm={handleConfirm}
                        handleComplete={handleComplete}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
