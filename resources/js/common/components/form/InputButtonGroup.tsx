import * as React from "react";
import { cn } from "@common/utils/utils";
import InputError from "@common/components/form/InputError";

type TProps = {
    name: string;
    label?: string;
    error?: string;
    button: React.ReactNode;
    className?: string;
} & Omit<React.ComponentProps<'input'>, 'name' | 'className'>;

export default function InputButtonGroup({
    name,
    label,
    error,
    button,
    className,
    ...inputProps
}: TProps) {
    return (
        <div className="form-group">
            {label && <label htmlFor={name}>{label}</label>}
            <div className={cn("input-group", className)}>
                <input
                    id={name}
                    name={name}
                    className="form-control"
                    {...inputProps}
                />
                {button}
            </div>
            <InputError message={error} />
        </div>
    );
}
