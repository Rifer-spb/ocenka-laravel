import * as React from "react";
import DatePicker, { DatePickerProps } from "react-datepicker";
import { cn } from "@common/utils/utils";
import InputError from "@common/components/form/InputError";
import {useId} from "react";

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
    value: Date | null;
    onChange: (date: Date | null) => void;
};

export default function DatePickerGroup({
    name,
    label,
    error,
    className,
    value,
    onChange,
    ...props
}: TProps) {
    const id = useId();

    return (
        <div className='form-group'>
            {label && <label htmlFor={id}>{label}</label>}
            <DatePicker
                id={id}
                name={name}
                selected={value}
                onChange={(date: Date | null) => onChange(date)}
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
