import CheckboxGroup from "@common/components/form/CheckboxGroup";
import { TEmployees } from './types';

type TProps = {
    employees: TEmployees[];
    handler: Function;
}

export default function Access({ employees, handler } : TProps) {
    return (
        <div className='table'>
            {employees.map((employee, index) => (
                <div className='tr' key={index}>
                    <div className='td'>{employee.name}</div>
                    <div className='td'>
                        <CheckboxGroup
                            key={index}
                            checked={employee.canCall}
                            onChange={() => handler(employee.id)}
                        />
                    </div>
                </div>
            ))}
        </div>
    );
}
