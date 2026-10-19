import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@manager/components/invite/types";
import { reSend, cancel, confirm as confirmInvite, close } from "@managerRoutes/legal/invites";
import { updateDoReport, updateWriteReport, updateRide, updateManager, updateWorkRate } from "@managerRoutes/legal/employees";

interface IProps {
    currentTab: IInviteTab
    invites: IInviteItem[];
}

export default function({ currentTab, invites } : IProps) {
    const handleReSend = (id: number) => {
        router.post(reSend.url(id));
    };

    const handleCancel = (id: number) => {
        router.patch(cancel.url(id));
    };

    const handleConfirm = (id: number) => {
        router.patch(confirmInvite.url(id));
    };

    const handleClose = (id: number) => {
        if (confirm('Уверены что хотите завершить связь с сотрудником?')) {
            router.patch(close.url(id));
        }
    };

    const handleUpdateDoReport = (id: number, accessId: number) => {
        router.patch(updateDoReport.url({ employee: id, accessId: accessId }));
    };

    const handleUpdateWriteReport = (id: number, accessId: number) => {
        router.patch(updateWriteReport.url({ employee: id, accessId: accessId }));
    };

    const handleUpdateRide = (id: number) => {
        router.patch(updateRide.url(id));
    };

    const handleUpdateManager = (id: number) => {
        router.patch(updateManager.url(id));
    };

    const handleUpdateWorkRate = (id: number, value: number) => {
        router.patch(updateWorkRate.url(id), { value: value });
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
