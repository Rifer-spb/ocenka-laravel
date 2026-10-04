import AppLayout from "@manager/layouts/appManagerLayout";
import './styles.css';
import FormComponent from './FormComponent';
import InvitesComponent from "./InvitesComponent";
import InviteTabsComponent from "@manager/components/invite/InviteTabs";
import {useManagerRoute} from "@manager/hooks/useAppRoute";
import {IInviteTab} from "@manager/components/invite/types";
import {router} from "@inertiajs/react";
import {IInviteItem} from "./types";
import {useEffect, useState} from "react";

type TProps = {
    tabs: IInviteTab[];
    counts: any;
    invites: IInviteItem[];
}

export default function ({ tabs, counts, invites: initialInvites } : TProps) {
    const route = useManagerRoute();
    const [invites, setInvites] = useState<IInviteItem[]>([]);

    const handleSelectTab = (currentTab : IInviteTab) => {
        setInvites([]);
        router.get(route('settings/invites'), { type: currentTab.id }, {
            only: ['invites'],
            preserveState: true,
            replace: true,
        });
    }

    useEffect(() => {
        setInvites(initialInvites);
    }, [initialInvites]);

    return (
        <AppLayout>
            <div>
                <h1>Установленные связи с сотрудниками</h1>
                <FormComponent/>
                <InviteTabsComponent tabs={tabs} counts={counts} handleEvent={handleSelectTab}>
                    {({ currentTab }) => (<InvitesComponent currentTab={currentTab} invites={invites} />)}
                </InviteTabsComponent>
            </div>
        </AppLayout>
    );
}
