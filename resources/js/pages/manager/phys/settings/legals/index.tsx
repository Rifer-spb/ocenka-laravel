import AppLayout from '@/layouts/appManagerLayout';
import FormComponent from "./FormComponent";
import InviteTabsComponent from "@/components/app/manager/legal/InviteTabsComponent";

export default function ({ invites }) {
    console.log(invites);

    return (
        <AppLayout>
            <div>
                <h1>Установленные связи с юр. лицами</h1>
                <FormComponent />
                <InviteTabsComponent>
                    {({ activeTab }) => (
                        <>
                            {
                                invites.length
                                    ? invites.map((item, index) => (
                                        <div>{ item.id }</div>
                                    ))
                                    : 'Заявок не найдено'
                            }
                        </>
                    )}
                </InviteTabsComponent>
            </div>
        </AppLayout>
    );
}
