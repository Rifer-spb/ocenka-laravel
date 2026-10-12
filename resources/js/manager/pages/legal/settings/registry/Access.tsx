import CheckboxGroup from "@common/components/form/CheckboxGroup";
import {TEmployeesAccess} from "@manager/types";

type TProps = {
    employees: TEmployeesAccess[];
    handler: Function;
}

export default function Access({ employees, handler } : TProps) {
    return (
        <section className='template'>
            <h2>Права сотрудников</h2>
            <div className='table'>
                {employees.map((employee, index) => (
                    <div className='tr' key={index}>
                        <div className='td'>{employee.name}</div>
                        <div className='td'>
                            <CheckboxGroup
                                key={index}
                                checked={employee.value}
                                onChange={() => handler(employee.id)}
                            />
                        </div>
                    </div>
                ))}
            </div>
        </section>
    );
}
