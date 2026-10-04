import * as React from "react";
import { cn } from "@common/utils/utils";
import InputError from "@common/components/form/InputError";

type TProps = React.ComponentProps<'textarea'> & {
    name: string;
    label?: string;
    error?: string;
};

export default function TextareaGroup({ name, label, error, className, id, rows = 4, ...props }: TProps) {
    const textareaId = id ?? name;

    return (
        <div className="form-group">
            {label && <label htmlFor={textareaId}>{label}</label>}
            <textarea
                id={textareaId}
                name={name}
                rows={rows}
                data-slot="textarea"
                className={cn("form-control", className)}
                {...props}
            />
            <InputError message={error} />
        </div>
    );
}
