import { InviteItem } from './types';

export default function({ invite } : { invite: InviteItem }) {
    return (
        <div className="tr">
            <div className="td date"> { invite.created_at } </div>
            <div className="td name"> { invite.legal.name } </div>
            <div className="td status">
                <div className={`status-${invite.status.id}`}>{ invite.status.name }</div>
            </div>
            <div className="td">

            </div>
        </div>
    );
}
