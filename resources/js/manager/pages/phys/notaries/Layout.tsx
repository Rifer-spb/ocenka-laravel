import AppLayout from '@manager/layouts/appManagerLayout';
import NavTabs from '@manager/components/common/navTabs/NavTabs';
import {ReactNode, useState} from "react";
import { TNavTabLink } from "@manager/components/common/navTabs/types";
import {useManagerRoute} from "@manager/hooks/useAppRoute";

type TProps = {
    children: ReactNode;
};

export default function ({ children } : TProps) {
    const route = useManagerRoute();
    const [tabItems] = useState<TNavTabLink[]>([
        { url: route('notaries'), name: 'Список' },
        { url: route('notaries/export'), name: 'Месячная выгрузка заказов по регионам' },
        { url: route('notaries/region-export'), name: 'Месячная выгрузка нотариусов по регионам' },
    ]);

    return (
        <AppLayout>
            <h1>Нотариусы</h1>
            <NavTabs items={tabItems}>{children}</NavTabs>
        </AppLayout>
    );
}
