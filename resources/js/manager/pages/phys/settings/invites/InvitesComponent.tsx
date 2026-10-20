import InviteComponent from './InviteComponent';
import { IInviteItem } from './types';
import { router } from '@inertiajs/react';
import {IInviteTab} from "@manager/components/invite/types";
import { reSend, cancel, confirm } from "@managerRoutes/phys/invites";

type Props = {
    invites: IInviteItem[];
    currentTab: IInviteTab;
}

export default function({ invites, currentTab } : Props) {
    const handleReSend = (id: number) => {
        router.patch(reSend.url(id));
    };

    const handleCancel = (id: number) => {
        router.patch(cancel.url(id));
    };

    const handleConfirm = (id: number) => {
        router.patch(confirm.url(id));
    };

    return (
        <div className="invites">
            {invites.length
                ? <div className="table">
                    <div className="tr">
                        <div className="th date">Дата</div>
                        <div className="th name">Юр. лицо</div>
                        <div className="th status">Статус</div>
                        <div className="th action">Действие</div>
                    </div>
                    {invites.map(invite => <InviteComponent
                        key={invite.id}
                        invite={invite}
                        currentTab={currentTab}
                        handleReSend={handleReSend}
                        handleCancel={handleCancel}
                        handleConfirm={handleConfirm}
                    />)}
                </div>
                : <div>Заявок не найдено</div>
            }
        </div>
    );
}
