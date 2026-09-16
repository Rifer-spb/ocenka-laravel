import { update } from "@/routes/manager/phys/settings/account/holiday";
import { Label } from "@/components/ui/label";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { useForm } from "@inertiajs/react";
import InputError from "@/components/app/form/InputError";
import { router } from "@inertiajs/react";
import {usePage} from "@inertiajs/react";

interface IProps {
    holiday_from: Date | null;
    holiday_to: Date | null;
}

export default function ({holiday_from, holiday_to}: IProps) {
    const { errors } = usePage().props;
    const { data, setData } = useForm({
        holidayFrom: holiday_from,
        holidayTo: holiday_to,
    });

    const handleDateChange = (field: "holidayFrom" | "holidayTo", date: Date | null) => {
        setData(field, date);

        const newData = {
            ...data,
            [field]: date,
        };

        router.patch(update.url(), newData, {
            preserveScroll: true,
            preserveState: true
        });
    };

    return (
        <section className="holiday">
            <h2>Отпуск</h2>
            <div className="form-group">
                <Label>От</Label>
                <DatePicker
                    selected={data.holidayFrom}
                    placeholderText="Выберите дату"
                    showMonthDropdown
                    dropdownMode="select"
                    dateFormat="dd.MM.yyyy"
                    showMonthYearDropdown={true}
                    onSelect={(date: Date | null) => handleDateChange('holidayFrom', date)}
                    className="form-control"
                />
                <InputError message={errors.holidayFrom} />
            </div>
            <div className="form-group">
                <Label>До</Label>
                <DatePicker
                    selected={data.holidayTo}
                    placeholderText="Выберите дату"
                    showMonthDropdown
                    dropdownMode="select"
                    dateFormat="dd.MM.yyyy"
                    showMonthYearDropdown={true}
                    onSelect={(date: Date | null) => handleDateChange('holidayTo', date)}
                    className="form-control"
                />
                <InputError message={errors.holidayTo} />
            </div>
        </section>
    );
}
