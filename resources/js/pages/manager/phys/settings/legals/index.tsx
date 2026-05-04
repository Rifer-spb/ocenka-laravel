import AppLayout from '@/layouts/appManagerLayout';
import FormComponent from "./FormComponent";
import { InviteTab } from '@/components/app/manager/legal/inviteTabs/types';
import InviteTabsComponent from "@/components/app/manager/legal/inviteTabs/InviteTabsComponent";
import { useManagerRoute } from "@/hooks/useManagerRoute";
import InvitesComponent from './InvitesComponent';
import { InviteItem } from './types';
import './styles.css';
import { router } from '@inertiajs/react';

export default function ({ tabs, counts, invites } : { invites: InviteItem[] }) {
    const route = useManagerRoute();

    const handleSelectTab = (currentTab : InviteTab) => {
        router.get(route('settings/legals'), { type: currentTab.id }, {
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
                    <InvitesComponent invites={invites} />
                </InviteTabsComponent>
            </div>
        </AppLayout>
    );
}
