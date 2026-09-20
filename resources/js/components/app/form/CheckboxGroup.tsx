import * as React from "react";
import InputError from "@/components/app/form/InputError";

type TProps = Omit<React.ComponentProps<'input'>, 'type'> & {
    name: string;
    label?: string;
    error?: string;
    className?: string;
    labelPosition?: 'left' | 'right';
};

export default function CheckboxGroup({
    name,
    label,
    error,
    className,
    labelPosition = 'right',
    ...props
}: TProps) {
    return (
        <div className='form-group'>
            <label>
                {label && labelPosition === 'left' && <span className='label'>{label}</span>}
                <input
                    name={name}
                    type="checkbox"
                    className={className}
                    {...props}
                />
                {label && labelPosition === 'right' && <span className='label'>{label}</span>}
            </label>
            <InputError message={error} />
        </div>
    );
}
