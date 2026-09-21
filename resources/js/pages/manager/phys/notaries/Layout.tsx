import AppLayout from '@/layouts/appManagerLayout';
import NavTabs from '@/components/app/manager/common/navTabs/NavTabs';
import {ReactNode, useState} from "react";
import { TNavTabLink } from "@/components/app/manager/common/navTabs/types";
import {useManagerRoute} from "@/hooks/useAppRoute";

type TProps = {
    children: ReactNode;
};

export default function ({ children } : TProps) {
    const route = useManagerRoute();
    const [tabItems] = useState<TNavTabLink[]>([
        { url: route('notaries'), name: 'Список' },
        { url: route('notaries/export'), name: 'Выгрузка' },
        { url: route('notaries/region-export'), name: 'Выгрузка по регионам' },
    ]);

    return (
        <AppLayout>
            <h1>Нотариусы</h1>
            <NavTabs items={tabItems}>{children}</NavTabs>
        </AppLayout>
    );
}
