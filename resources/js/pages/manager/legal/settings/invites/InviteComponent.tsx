import { IInviteItem } from './types';
import {IInviteTab} from "@/components/app/manager/legal/invite/types";
import ButtonsComponent from './ButtonsComponent';
import CheckboxItem from "@/components/app/CheckboxItem";
import {Input} from "@/components/ui/input";

interface IProps {
    currentTab: IInviteTab;
    invite: IInviteItem;
    handleReSend: Function;
    handleCancel: Function;
    handleConfirm: Function;
    handleClose: Function;
    handleUpdateDoReport: Function;
    handleUpdateWriteReport: Function;
    handleUpdateRide: Function;
    handleUpdateManager: Function;
    handleUpdateWorkRate: Function;
}

export default function({
    currentTab,
    invite,
    handleReSend,
    handleCancel,
    handleConfirm,
    handleClose,
    handleUpdateDoReport,
    handleUpdateWriteReport,
    handleUpdateRide,
    handleUpdateManager,
    handleUpdateWorkRate
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
                                labelName={item.name}
                                checked={item.write}
                                handler={() => handleUpdateWriteReport(invite.id, item.id)}
                            />
                        )}
                    </div>
                    <div className="td access">
                        <CheckboxItem
                            checked={invite.employee.access.ride}
                            handler={() => handleUpdateRide(invite.id)}
                        />
                    </div>
                    <div className="td is_manager">
                        <CheckboxItem
                            checked={invite.employee.isManager}
                            handler={() => handleUpdateManager(invite.id)}
                        />
                    </div>
                    <div className="td work_rate">
                        <Input
                            id="is_manager"
                            name="is_manager"
                            type="text"
                            required
                            value={invite.employee.workRate ?? ''}
                            onChange={(e) => handleUpdateWorkRate(invite.id, e.target.value)}
                            style={{backgroundColor: '#fff'}}
                        />
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
                    handleClose={handleClose}
                />
            </div>
        </div>
    );
}
