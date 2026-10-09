import * as React from "react";
import DatePicker, { DatePickerProps } from "react-datepicker";
import { cn } from "@common/utils/utils";
import InputError from "@common/components/form/InputError";
import {useId, useState} from "react";

type TPickerProps = Pick<
DatePickerProps,
| 'minDate'
| 'maxDate'
| 'disabled'
| 'required'
| 'placeholderText'
| 'dateFormat'
| 'showTimeSelect'
| 'filterDate'
| 'excludeDates'
| 'openToDate'
>;

type TProps = TPickerProps & {
    name?: string;
    label?: string;
    error?: string;
    className?: string;
    value?: Date | null;
    defaultValue?: Date | null;
    onChange?: (date: Date | null) => void;
};

export default function DatePickerGroup({
    name,
    label,
    error,
    className,
    value,
    defaultValue = null,
    onChange,
    ...props
}: TProps) {
    const id = useId();
    const isControlled = value !== undefined;
    const [internalValue, setInternalValue] = useState<Date | null>(defaultValue);

    const selected = isControlled ? value : internalValue;

    const handleChange = (date: Date | null) => {
        if (!isControlled) {
            setInternalValue(date);
        }
        onChange?.(date);
    };

    return (
        <div className='form-group'>
            {label && <label htmlFor={id}>{label}</label>}
            <DatePicker
                id={id}
                name={name}
                selected={selected}
                onChange={handleChange}
                placeholderText='Выберите дату'
                dateFormat='dd.MM.yyyy'
                showMonthDropdown
                showYearDropdown
                dropdownMode='select'
                autoComplete='off'
                className={cn('form-control', className)}
                {...props}
            />
            <InputError message={error} />
        </div>
    );
}
