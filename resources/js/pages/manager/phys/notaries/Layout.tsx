import AppLayout from '@/layouts/appManagerLayout';
import StaticTabs from '@/components/app/manager/common/staticTabs/StaticTabs';
import {ReactNode, useState} from "react";
import { TStaticTabLink } from "@/components/app/manager/common/staticTabs/types";

type TProps = {
    children: ReactNode;
};

export default function ({ children } : TProps) {
    const [tabItems] = useState<TStaticTabLink[]>([
        { url: '/manager/phys/notaries', name: 'Список' },
        { url: '/manager/phys/notaries/export', name: 'Выгрузка' },
        { url: '/manager/phys/notaries/region-export', name: 'Выгрузка по регионам' },
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
