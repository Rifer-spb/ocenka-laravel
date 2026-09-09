import { IInviteItem } from './types';
import {IInviteTab} from "@/components/app/manager/legal/inviteTabs/types";
import ButtonsComponent from './ButtonsComponent';
import CheckboxItem from "@/components/app/CheckboxItem";

interface IProps {
    currentTab: IInviteTab;
    invite: IInviteItem;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
    handleComplete: Function;
    handleUpdateDoReport: Function;
    handleUpdateWriteReport: Function;
}

export default function({
    currentTab,
    invite,
    handleReSend,
    handleCancel,
    handleConfirm,
    handleComplete,
    handleUpdateDoReport,
    handleUpdateWriteReport
} : IProps) {
    return (
        <div className="tr">
            <div className="td date"> {currentTab.id == 'complete' ? invite.completed_at : invite.created_at} </div>
            <div className="td name"> {invite.employee.name} </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{invite.status.name}</div>
            </div>
            {currentTab.id == 'active' && (
                <>
                    <div className="td access">
                        {invite.employee.access.report.map(
                            item => <CheckboxItem
                                key={item.id}
                                showLabel={true}
                                labelName={item.name}
                                checked={item.do}
                                handler={() => handleUpdateDoReport(invite.id, item.id)}
                            />
                        )}
                    </div>
                    <div className="td access">
                        {invite.employee.access.report.map(
                            item => <CheckboxItem
                                key={item.id}
                                showLabel={true}
                                labelName={item.name}
                                checked={item.write}
                                handler={() => handleUpdateWriteReport(invite.id, item.id)}
                            />
                        )}
                    </div>
                    <div className="td access"></div>
                    <div className="td is_manager">
                        {invite.employee.isManager}
                    </div>
                    <div className="td work_rate">
                        {invite.employee.workRate}
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
