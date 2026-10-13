import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { useManagerRoute } from '@manager/hooks/useAppRoute';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@manager/components/invite/types";

interface IProps {
    currentTab: IInviteTab
    invites: IInviteItem[];
}

export default function({ currentTab, invites } : IProps) {
    const route = useManagerRoute();
    const baseUrlInvites = 'invites';
    const baseUrlEmployees = 'employees';

    const handleReSend = (id: number) => {
        router.post(route(`${baseUrlInvites}/${id}/re-send`));
    };

    const handleCancel = (id: number) => {
        router.patch(route(`${baseUrlInvites}/${id}/cancel`));
    };

    const handleConfirm = (id: number) => {
        router.patch(route(`${baseUrlInvites}/${id}/confirm`));
    };

    const handleClose = (id: number) => {
        if (confirm('Уверены что хотите завершить связь с сотрудником?')) {
            router.patch(route(`${baseUrlInvites}/${id}/close`));
        }
    };

    const handleUpdateDoReport = (id: number, accessId: number) => {
        router.patch(route(`${baseUrlEmployees}/${id}/do-report/${accessId}`));
    };

    const handleUpdateWriteReport = (id: number, accessId: number) => {
        router.patch(route(`${baseUrlEmployees}/${id}/write-report/${accessId}`));
    };

    const handleUpdateRide = (id: number) => {
        router.patch(route(`${baseUrlEmployees}/${id}/ride`));
    };

    const handleUpdateManager = (id: number) => {
        router.patch(route(`${baseUrlEmployees}/${id}/manager`));
    };

    const handleUpdateWorkRate = (id: number, value: number) => {
        router.patch(route(`${baseUrlEmployees}/${id}/work-rate`), { value: value });
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
