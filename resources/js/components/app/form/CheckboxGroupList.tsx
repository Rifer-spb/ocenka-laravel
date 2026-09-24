import * as React from "react";
import { cn } from "@/utils/utils";
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
    value?: (string | number)[];
    defaultValue?: (string | number)[];
    onChange?: (value: string[]) => void;
};

export default function CheckboxList({
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
    const selected = (isControlled ? value : defaultValue ?? []).map(String);

    const handleChange = (optionValue: string, checked: boolean) => {
        if (!onChange) return;

        const current = (value ?? []).map(String);
        onChange(
            checked
                ? [...current, optionValue]
                : current.filter((v) => v !== optionValue)
        );
    };

    return (
        <div className='form-group'>
            {label && <div className='label'>{label}</div>}
            <div role='group'>
                {options.map((option) => {
                    const optionValue = String(option.value);

                    return (
                        <label key={optionValue} className='checkbox-label'>
                            <input
                                type='checkbox'
                                name={`${name}[]`}
                                value={optionValue}
                                disabled={option.disabled}
                                className={cn(className)}
                                {...(isControlled
                                    ? { checked: selected.includes(optionValue) }
                                    : { defaultChecked: selected.includes(optionValue) })}
                                onChange={(e) => handleChange(optionValue, e.target.checked)}
                                {...props}
                            />
                            <span>{option.label}</span>
                        </label>
                    );
                })}
            </div>
            <InputError message={error} />
        </div>
    );
}
