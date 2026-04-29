import AppLayout from '@/layouts/appManagerLayout';
import FormComponent from "./FormComponent";
import { InviteTab } from '@/components/app/manager/legal/inviteTabs/types';
import InviteTabsComponent from "@/components/app/manager/legal/inviteTabs/InviteTabsComponent";
import {useState} from "react";
import { useManagerRoute } from "@/hooks/useManagerRoute";
import { getRequest } from "@/services/api";
import InvitesComponent from './InvitesComponent';
import { InviteItem } from './types';
import './styles.css';

export default function ({ invites } : { invites: InviteItem[] }) {
    const route = useManagerRoute();
    const [items, setItems] = useState(invites);

    const handleSelectTab = (currentTab : InviteTab) => {
        getRequest(route('settings/legals/search'), { type: currentTab.id })
            .then(response => setItems(response.data));
    }

    return (
        <AppLayout>
            <div>
                <h1>Установленные связи с юр. лицами</h1>
                <FormComponent />
                <InviteTabsComponent handleEvent={handleSelectTab}>
                    <InvitesComponent invites={items} />
                </InviteTabsComponent>
            </div>
        </AppLayout>
    );
}
