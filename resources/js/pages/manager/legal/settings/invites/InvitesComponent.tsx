import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { useManagerRoute } from '@/hooks/useAppRoute';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@/components/app/manager/invite/types";

interface IProps {
    currentTab: IInviteTab
    invites: IInviteItem[];
}

export default function({ currentTab, invites } : IProps) {
    const route = useManagerRoute();
    const baseUrl = 'settings/invites';

    const handleReSend = (id: number) => {
        router.post(route(`${baseUrl}/${id}/re-send`));
    };

    const handleCancel = (id: number) => {
        router.patch(route(`${baseUrl}/${id}/cancel`));
    };

    const handleConfirm = (id: number) => {
        router.patch(route(`${baseUrl}/${id}/confirm`));
    };

    const handleClose = (id: number) => {
        if (confirm('Уверены что хотите завершить связь с сотрудником?')) {
            router.patch(route(`${baseUrl}/${id}/close`));
        }
    };

    const handleUpdateDoReport = (id: number, accessId: number) => {
        router.patch(route(`${baseUrl}/${id}/do-report/${accessId}`));
    };

    const handleUpdateWriteReport = (id: number, accessId: number) => {
        router.patch(route(`${baseUrl}/${id}/write-report/${accessId}`));
    };

    const handleUpdateRide = (id: number) => {
        router.patch(route(`${baseUrl}/${id}/ride`));
    };

    const handleUpdateManager = (id: number) => {
        router.patch(route(`${baseUrl}/${id}/manager`));
    };

    const handleUpdateWorkRate = (id: number, value: number) => {
        router.patch(route(`${baseUrl}/${id}/work-rate`), { value: value });
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
                        handleClose={handleClose}
                        handleUpdateDoReport={handleUpdateDoReport}
                        handleUpdateWriteReport={handleUpdateWriteReport}
                        handleUpdateRide={handleUpdateRide}
                        handleUpdateManager={handleUpdateManager}
                        handleUpdateWorkRate={handleUpdateWorkRate}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
