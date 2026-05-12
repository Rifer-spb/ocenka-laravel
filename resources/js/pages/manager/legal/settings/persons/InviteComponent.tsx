import { IInviteItem } from './types';
import {IInviteTab} from "@/components/app/manager/legal/inviteTabs/types";
import ButtonsComponent from './ButtonsComponent';

interface IProps {
    currentTab: IInviteTab;
    invite: IInviteItem;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
    handleComplete: Function;
}

export default function({ currentTab, invite, handleReSend, handleCancel, handleConfirm, handleComplete } : IProps) {
    return (
        <div className="tr">
            <div className="td date"> {currentTab.id == 'complete' ? invite.completed_at : invite.created_at} </div>
            <div className="td name"> {invite.phys.name} </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{invite.status.name}</div>
            </div>
            {currentTab.id == 'active' && (
                <>
                    <div className="td can_report_write"></div>
                    <div className="td can_do_write"></div>
                    <div className="td can_ride"></div>
                    <div className="td is_manager">
                        {invite.phys.isManager}
                    </div>
                    <div className="td work_rate">
                        {invite.phys.workRate}
                    </div>
                </>
            )}
            <div className="td">
                <ButtonsComponent
                    id={invite.id}
                    currentTab={currentTab}
                    handleReSend={handleReSend}
                    handleConfirm={handleConfirm}
                    handleCancel={handleCancel}
                    handleComplete={handleComplete}
                />
            </div>
        </div>
    );
}
