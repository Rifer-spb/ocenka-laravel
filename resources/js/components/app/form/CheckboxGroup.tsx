import * as React from "react";
import InputError from "@/components/app/form/InputError";

type TProps = Omit<React.ComponentProps<'input'>, 'type'> & {
    name: string;
    label?: string;
    error?: string;
    className?: string;
    labelPosition?: 'left' | 'right';
};

const LabelComponent = ({ label } : {label: string})  =>
    <span className='label'>{label}</span>;

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
                {label && labelPosition === 'left' && <LabelComponent label={label}/>}
                <input
                    name={name}
                    type="checkbox"
                    className={className}
                    {...props}
                />
                {label && labelPosition === 'right' && <LabelComponent label={label}/>}
            </label>
            <InputError message={error}/>
        </div>
    );
}
