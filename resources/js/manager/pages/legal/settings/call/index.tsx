import AppLayout from "@manager/layouts/appManagerLayout";
import './styles.css';
import './types';
import Access from "./Access";
import {router} from "@inertiajs/react";
import { updateCall } from "@managerRoutes/legal/employees";

type TProps = {
    template: string;
    employees: TEmployees[];
};

export default function ({ employees } : TProps) {
    const handleChangeAccess = (employeeId: number) => {
        router.patch(updateCall.url(employeeId));
    }

    return (
        <AppLayout>
            <div className="call">
                <h1>Реестр звонков</h1>
                <Access employees={employees} handler={handleChangeAccess}/>
            </div>
        </AppLayout>
    );
};
