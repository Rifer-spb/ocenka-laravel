import { IInviteItem } from './types';
import {IInviteTab} from "@manager/components/invite/types";
import ButtonsComponent from './ButtonsComponent';
import CheckboxGroup from "@common/components/form/CheckboxGroup";
import InputGroup from "@common/components/form/InputGroup";

type IProps = {
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
};

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
                            item => <CheckboxGroup
                                key={item.id}
                                name='doReport'
                                label={item.name}
                                checked={item.do}
                                onChange={() => handleUpdateDoReport(invite.employee.id, item.id)}
                                labelPosition='left'
                            />
                        )}
                    </div>
                    <div className="td access">
                        {invite.employee.access.report.map(
                            item => <CheckboxGroup
                                key={item.id}
                                name='writeReport'
                                label={item.name}
                                checked={item.write}
                                onChange={() => handleUpdateWriteReport(invite.employee.id, item.id)}
                                labelPosition='left'
                            />
                        )}
                    </div>
                    <div className="td access">
                        <CheckboxGroup
                            name='ride'
                            checked={invite.employee.access.ride}
                            onChange={() => handleUpdateRide(invite.employee.id)}
                        />
                    </div>
                    <div className="td is_manager">
                        <CheckboxGroup
                            name='isManager'
                            checked={invite.employee.isManager}
                            onChange={() => handleUpdateManager(invite.employee.id)}
                        />
                    </div>
                    <div className="td work_rate">
                        <InputGroup
                            type="text"
                            name="workRate"
                            required
                            defaultValue={invite.employee.workRate ?? ''}
                            onChange={(e) => handleUpdateWorkRate(invite.employee.id, e.target.value)}
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
