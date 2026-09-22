import * as React from "react";
import { cn } from "@/utils/utils";
import InputError from "@/components/app/form/InputError";

type TOption = {
    value: string | number;
    label: string;
    disabled?: boolean;
};

type TProps = React.ComponentProps<'select'> & {
    name: string;
    options: TOption[] | Record<string | number, string>;
    label?: string;
    error?: string;
    placeholder?: string | false;
};

export default function SelectGroup({
    name,
    options,
    label,
    error,
    id,
    className,
    placeholder = 'Выберите из списка',
    ...props
}: TProps) {
    const selectId = id ?? name;

    const list: TOption[] = Array.isArray(options)
        ? options
        : Object.entries(options).map(([value, label]) => ({ value, label }));

    return (
        <div className="form-group">
            {label && <label htmlFor={selectId}>{label}</label>}
            <select
                id={selectId}
                name={name}
                data-slot="select"
                className={cn("form-control", className)}
                {...props}
            >
                {placeholder !== false && <option value="">{placeholder}</option>}

                {list.map((option) => (
                    <option key={option.value} value={option.value} disabled={option.disabled}>
                        {option.label}
                    </option>
                ))}
            </select>
            <InputError message={error} />
        </div>
    );
}
