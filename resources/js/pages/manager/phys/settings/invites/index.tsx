import AppLayout from '@/layouts/appManagerLayout';
import FormComponent from "./FormComponent";
import { IInviteTab } from '@/components/app/manager/invite/types';
import InviteTabsComponent from "@/components/app/manager/invite/InviteTabs";
import { useManagerRoute } from "@/hooks/useAppRoute";
import InvitesComponent from './InvitesComponent';
import { IInviteItem } from './types';
import './styles.css';
import { router } from '@inertiajs/react';

type TProps = {
    tabs: IInviteTab[];
    counts: any;
    invites: IInviteItem[];
}

export default function ({ tabs, counts, invites } : TProps) {
    const route = useManagerRoute();

    const handleSelectTab = (currentTab : IInviteTab) => {
        router.get(route('settings/invites'), { type: currentTab.id }, {
            only: ['invites'],
            preserveState: true,
            replace: true,
        });
    }

    return (
        <AppLayout>
            <div>
                <h1>Установленные связи с юр. лицами</h1>
                <FormComponent />
                <InviteTabsComponent tabs={tabs} counts={counts} handleEvent={handleSelectTab}>
                    {({ currentTab }) => <InvitesComponent currentTab={currentTab} invites={invites} />}
                </InviteTabsComponent>
            </div>
        </AppLayout>
    );
}
