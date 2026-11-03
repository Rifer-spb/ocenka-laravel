import {TEmployees} from "@manager/pages/legal/settings/calls/types";
import EmployeeExtension from "@manager/pages/legal/settings/calls/EmployeeExtension";

export default function ({ employees } : { employees: TEmployees[] }) {
    return !employees.length ? null : (
        <div className='employee-extensions table'>
            {employees.map((employee, index) =>
                <EmployeeExtension key={index} employee={employee} />
            )}
        </div>
    );
}
