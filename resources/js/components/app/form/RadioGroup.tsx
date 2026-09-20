import * as React from "react";
import { cn } from "@/lib/utils";
import InputError from "@/components/app/form/InputError";

type TOption = {
    value: string | number;
    label: string;
    disabled?: boolean;
};

type TProps = Omit<React.ComponentProps<'input'>, 'type' | 'value' | 'defaultValue' | 'onChange' | 'name'> & {
    name: string;
    options: TOption[];
    label?: string;
    error?: string;
    value?: string | number;         // управляемый режим
    defaultValue?: string | number;  // неуправляемый режим
    onChange?: (value: string) => void;
};

export default function RadioGroup({
   name,
   options,
   label,
   error,
   value,
   defaultValue,
   onChange,
   className,
   ...props
}: TProps) {
    const isControlled = value !== undefined;

    return (
        <div className='form-group'>
            {label && <div className='label'>{label}</div>}
            <div role='radiogroup'>
                {options.map((option) => (
                    <label key={option.value} className='radio-label'>
                        <input
                            type='radio'
                            name={name}
                            value={option.value}
                            disabled={option.disabled}
                            className={cn(className)}
                            {...(isControlled
                                ? { checked: String(value) === String(option.value) }
                                : { defaultChecked: defaultValue !== undefined && String(defaultValue) === String(option.value) })}
                            onChange={(e) => onChange?.(e.target.value)}
                            {...props}
                        />
                        <span>{option.label}</span>
                    </label>
                ))}
            </div>
            <InputError message={error} />
        </div>
    );
}
