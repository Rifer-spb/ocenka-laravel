import * as React from "react";
import { cn } from "@common/utils/utils";
import InputError from "@common/components/form/InputError";

type TProps = React.ComponentProps<'input'> & {
    name: string;
    label?: string;
    error?: string;
};

export default function InputGroup({ name, label, error, className, id, ...props }: TProps) {
    const inputId = id ?? name;

    return (
        <div className="form-group">
            {label && <label htmlFor={inputId}>{label}</label>}
            <input
                id={inputId}
                name={name}
                data-slot="input"
                className={cn("form-control", className)}
                {...props}
            />
            <InputError message={error} />
        </div>
    );
}
