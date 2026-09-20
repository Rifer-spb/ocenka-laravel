import * as React from "react";
import { cn } from "@/lib/utils";
import InputError from "@/components/app/form/InputError";

type TProps = React.ComponentProps<'select'> & {
    name: string;
    options: Record<string | number, string>;
    label?: string;
    errorText?: string;
    placeholder?: string | false;
};

export default function SelectGroup({
    name,
    options,
    label,
    errorText,
    id,
    className,
    placeholder = 'Выберите из списка',
    ...props
}: TProps) {
    const selectId = id ?? name;

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

                {Object.entries(options).map(([value, text]) => (
                    <option key={value} value={value}>{text}</option>
                ))}
            </select>
            <InputError message={errorText} />
        </div>
    );
}
