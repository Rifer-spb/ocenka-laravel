import AppLayout from "@/layouts/appManagerLayout";
import './styles.css';
import Template from "./Template";
import './types';
import Access from "@/pages/manager/legal/settings/registry/Access";
import {router} from "@inertiajs/react";
import {updateAccess} from "@/routes/manager/legal/settings/registry";

type TProps = {
    template: string;
    employees: TEmployees[];
};

export default function ({ template, employees } : TProps) {
    const handleChangeAccess = (employeeId: number) => {
        router.patch(updateAccess.url(employeeId));
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
