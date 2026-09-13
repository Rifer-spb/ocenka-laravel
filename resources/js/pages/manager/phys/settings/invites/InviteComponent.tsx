import { IInviteItem } from './types';
import ButtonsComponent from "./ButtonsComponent";
import {IInviteTab} from "@/components/app/manager/legal/invite/types";

interface IProps {
    currentTab: IInviteTab
    invite: IInviteItem;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
}

export default function({ currentTab, invite, handleReSend, handleCancel, handleConfirm } : IProps) {
    return (
        <div className="tr">
            <div className="td date"> { currentTab.id == 'complete' ? invite.completed_at : invite.created_at } </div>
            <div className="td name"> { invite.legal.name } </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{ invite.status.name }</div>
            </div>
            <div className="td">
                <ButtonsComponent
                    id={invite.id}
                    currentTab={currentTab}
                    handleReSend={handleReSend}
                    handleCancel={handleCancel}
                    handleConfirm={handleConfirm}
                />
            </div>
        </div>
    );
}
