import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { useManagerRoute } from '@/hooks/useManagerRoute';
import { router } from '@inertiajs/react';

export default function({ invites } : { invites: IInviteItem[] }) {
    const route = useManagerRoute();

    const handleReSend = (id: number) => {
        router.post(route(`settings/legals/re-send/${id}`));
    };

    const handleCancel = (id: number) => {
        router.post(route(`settings/legals/cancel/${id}`));
    };

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
                    {invites.map(invite => <InviteComponent
                        key={invite.id}
                        invite={invite}
                        handleReSend={handleReSend}
                        handleCancel={handleCancel}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
