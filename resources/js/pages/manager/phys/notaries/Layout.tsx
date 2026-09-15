import AppLayout from '@/layouts/appManagerLayout';
import StaticTabs from '@/components/app/manager/common/staticTabs/StaticTabs';
import {ReactNode, useState} from "react";
import { TStaticTabLink } from "@/components/app/manager/common/staticTabs/types";
import {useManagerRoute} from "@/hooks/useAppRoute";

type TProps = {
    children: ReactNode;
};

export default function ({ children } : TProps) {
    const route = useManagerRoute();

    const [tabItems] = useState<TStaticTabLink[]>([
        { url: route('notaries'), name: 'Список' },
        { url: route('notaries/export'), name: 'Выгрузка' },
        { url: route('notaries/region-export'), name: 'Выгрузка по регионам' },
    ]);

    return (
        <AppLayout>
            <div>
                <h1>Нотариусы</h1>
                <StaticTabs items={tabItems}>{children}</StaticTabs>
            </div>
        </AppLayout>
    );
}
