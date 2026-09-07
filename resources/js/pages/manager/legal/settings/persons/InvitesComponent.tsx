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
        router.patch(route(`settings/persons/cancel/${id}`));
    };

    const handleConfirm = (id: number) => {
        router.patch(route(`settings/persons/confirm/${id}`));
    };

    const handleComplete = (id: number) => {
        router.patch(route(`settings/persons/complete/${id}`));
    };

    const handleUpdateDoReport = (employeeId: number, accessId: number) => {
        router.patch(route(`employees/${employeeId}/report-access/${accessId}/do`));
    };

    return (
        <div className="invites">
            {invites.length
                ? <div className="table">
                    <div className="tr">
                        <div className="th date">Дата</div>
                        <div className="th name">Сотрудник</div>
                        <div className="th status">Статус</div>
                        {currentTab.id == 'active' && (
                            <>
                                <div className="th can_report_write">Может подп.отч. по напр.</div>
                                <div className="th can_do_write">Может дел. отч. по напр.</div>
                                <div className="th can_ride">Может езд. на выез.</div>
                                <div className="th is_manager">Менеджер</div>
                                <div className="th work_rate">Норма</div>
                            </>
                        )}
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
                        handleUpdateDoReport={handleUpdateDoReport}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
