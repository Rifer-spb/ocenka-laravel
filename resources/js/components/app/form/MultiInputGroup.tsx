import * as React from "react";
import { cn } from "@/utils/utils";
import InputError from "@/components/app/form/InputError";
import {useId, useState, useRef} from "react";

type TProps = Omit<React.ComponentProps<'input'>,
'name' | 'value' | 'defaultValue' | 'onChange' | 'id'
> & {
    name: string;
    label?: string;
    error?: string;
    itemErrors?: Record<number, string | undefined>;
    value?: string[];
    defaultValue?: string[];
    onChange?: (values: string[]) => void;
    minItems?: number;
    maxItems?: number;
};

export default function MultiInputGroup({
    name,
    label,
    error,
    itemErrors,
    value,
    defaultValue,
    onChange,
    minItems,
    maxItems,
    className,
    ...props
}: TProps) {
    const baseId = useId();
    const isControlled = value !== undefined;

    const nextId = useRef(0);
    const [rows, setRows] = useState(() =>
        (defaultValue?.length ? defaultValue : ['']).map((v) => ({ id: nextId.current++, value: v }))
    );

    const items = isControlled
        ? (value.length ? value : ['']).map((v, i) => ({ key: i, value: v }))
        : rows.map((r) => ({ key: r.id, value: r.value }));

    const canAdd = maxItems === undefined || items.length < maxItems;
    const canRemove = minItems === undefined || items.length > minItems;

    const handleAdd = () => {
        if (isControlled) {
            onChange?.([...items.map((i) => i.value), ''])
        } else {
            setRows((r) => [...r, { id: nextId.current++, value: '' }]);
        }
    };

    const handleRemove = (index: number, key: number) => {
        if (isControlled) {
            onChange?.(items.filter((_, i) => i !== index).map((i) => i.value));
        } else {
            setRows((r) => r.filter((row) => row.id !== key));
        }
    };

    const handleInput = (index: number, next: string) => {
        onChange?.(items.map((item, i) => (i === index ? next : item.value)));
    };

    return (
        <div className="form-group multi-input">
            <div className="multi-input-header">
                {label && <label htmlFor={`${baseId}-0`}>{label}</label>}
                {canAdd && (<a href='#' onClick={handleAdd} style={{ marginLeft: '5px', textDecoration: "none"}}>[+]</a>)}
            </div>

            {items.map((item, index) => (
                <div key={item.key} className="multi-input-row" style={{marginBottom: 10}}>
                    <div className="multi-input-field" style={{position: "relative"}}>
                        <input
                            id={`${baseId}-${index}`}
                            name={`${name}[]`}
                            data-slot="input"
                            className={cn("form-control", className)}
                            {...(isControlled
                                ? {value: item.value, onChange: (e) => handleInput(index, e.target.value)}
                                : {defaultValue: item.value})}
                            {...props}
                        />
                        {canRemove && (<a href='#' onClick={() => handleRemove(index, item.key)} style={{
                            position: "absolute",
                            right: 11,
                            top: 11,
                            textDecoration: "none",
                            fontSize: "1.2rem",
                            color: "#4c4c4c"
                        }}>×</a>)}
                    </div>

                    <InputError message={itemErrors?.[index]}/>
                </div>
            ))}

            <InputError message={error} />
        </div>
    );
}
