import {TEmployees} from "@manager/pages/legal/settings/calls/types";
import InputGroup from "@common/components/form/InputGroup";
import { updatePhoneExtension } from "@managerRoutes/legal/employees";
import { useForm } from "@inertiajs/react";

export default function ({ employee } : { employee: TEmployees }) {
    const form = useForm({
        value: employee.phoneExtension ?? '',
    });

    const handleBlur = () => {
        if (form.data.value === (employee.phoneExtension ?? '')) {
            return;
        }

        form.patch(updatePhoneExtension.url(employee.id), {
            preserveScroll: true,
        });
    };

    return (
        <div className='tr'>
            <div className='td'>{employee.name}</div>
            <div className='td'>
                <InputGroup
                    type="text"
                    name={`extension-${employee.id}`}
                    value={form.data.value}
                    onChange={(e) => form.setData('value', e.target.value)}
                    onBlur={handleBlur}
                    error={form.errors.value}
                    disabled={form.processing}
                    className='align-center'
                />
            </div>
        </div>
    );
}
