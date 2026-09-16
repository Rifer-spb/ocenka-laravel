import { Label } from "@/components/ui/label";
import InputError from "@/components/app/form/InputError";
import * as React from "react";
import {useQueryParams} from "@/hooks/useQueryParams";

type TProps = {
    name: string;
    type?: string;
    error?: string;
    label?: string;
    placeholder?: string;
    disabled?: boolean;
}

export default ({
    name,
    type = 'text',
    error,
    label,
    placeholder = '',
    disabled = false,
} : TProps) => {
    const queryParams = useQueryParams();
    const selected = queryParams[name];

    return (
        <div className="form-group">
            {label && <Label htmlFor={name}>{label}</Label>}
            <input
                id={name}
                name={name}
                type={type}
                data-slot="input"
                className='form-control'
                required
                style={{backgroundColor: '#fff'}}
                placeholder={placeholder}
                disabled={disabled}
                defaultValue={selected ?? ''}
            />
            <InputError message={error} />
        </div>
    );
}
