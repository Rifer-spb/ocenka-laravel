import AppLayout from "@manager/layouts/appManagerLayout";
import './styles.css';
import Template from "./Template";
import Access from "./Access";
import {router} from "@inertiajs/react";
import { updateRegistry } from "@managerRoutes/legal/employees";
import {TEmployeesAccess} from "@manager/types";

type TProps = {
    template: string;
    employees: TEmployeesAccess[];
};

export default function ({ template, employees } : TProps) {
    const handleChangeAccess = (employeeId: number) => {
        router.patch(updateRegistry.url(employeeId));
    }

    return (
        <AppLayout>
            <div className="registry">
                <h1>Реестр договоров</h1>
                <Template template={template} />
                <Access employees={employees} handler={handleChangeAccess}/>
            </div>
        </AppLayout>
    );
};
