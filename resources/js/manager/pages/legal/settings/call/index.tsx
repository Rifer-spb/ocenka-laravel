import AppLayout from "@manager/layouts/appManagerLayout";
import './styles.css';
import Access from "./Access";
import {router} from "@inertiajs/react";
import { updateCall } from "@managerRoutes/legal/employees";
import {TEmployeesAccess} from "@manager/types";
import Templates from "./Templates";
import './types';
import BlockSection from "@manager/components/common/BlockSection";

type TProps = {
    employees: TEmployeesAccess[];
    templates: TTemplate[];
};

export default function ({ employees, templates } : TProps) {
    const handleChangeAccess = (employeeId: number) => {
        router.patch(updateCall.url(employeeId));
    }

    return (
        <AppLayout>
            <div className="call">
                <h1>Реестр звонков</h1>
                <BlockSection label='Права сотрудников' maxWidth='300px'>
                    <Access employees={employees} handler={handleChangeAccess}/>
                </BlockSection>
                <BlockSection label='Шаблоны комментариев' maxWidth='900px' className='templates'>
                    <Templates templates={templates}/>
                </BlockSection>
            </div>
        </AppLayout>
    );
};
