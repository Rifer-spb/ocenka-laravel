import InviteComponent from './InviteComponent';
import { InviteItem } from './types';

export default function({ invites } : { invites: InviteItem[] }) {
    return (
        <div className="invites">
            {invites.length
                ? <div className="table">
                    <div className="tr">
                        <div className="th date">Дата</div>
                        <div className="th name">Сотрудник</div>
                        <div className="th status">Статус</div>
                        <div className="th action">Действие</div>
                    </div>
                    {invites.map(invite => <InviteComponent key={invite.id} invite={invite}/>)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
