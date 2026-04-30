import { InviteItem } from './types';
import { Button } from '@/components/ui/button';

export default function({ invite } : { invite: InviteItem }) {
    return (
        <div className="tr">
            <div className="td date"> { invite.created_at } </div>
            <div className="td name"> { invite.legal.name } </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{ invite.status.name }</div>
            </div>
            <div className="td">
                <div className="btn-group">
                    <Button type="button" className="btn btn-success">Повторить</Button>
                    <Button type="button" className="btn btn-primary">Отозвать</Button>
                </div>
            </div>
        </div>
    );
}
