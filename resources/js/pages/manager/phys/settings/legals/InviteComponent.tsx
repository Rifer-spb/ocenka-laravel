import { IInviteItem } from './types';
import { Button } from '@/components/ui/button';

interface IProps {
    invite: IInviteItem,
    handleReSend: Function,
    handleCancel: Function
}

export default function({ invite, handleReSend, handleCancel } : IProps) {
    return (
        <div className="tr">
            <div className="td date"> { invite.created_at } </div>
            <div className="td name"> { invite.legal.name } </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{ invite.status.name }</div>
            </div>
            <div className="td">
                <div className="btn-group">
                    <Button
                        type="button"
                        className="btn btn-success"
                        onClick={() => handleReSend(invite.id)}
                    >Повторить</Button>
                    <Button
                        type="button"
                        className="btn btn-primary"
                        onClick={() => handleCancel(invite.id)}
                    >Отозвать</Button>
                </div>
            </div>
        </div>
    );
}
