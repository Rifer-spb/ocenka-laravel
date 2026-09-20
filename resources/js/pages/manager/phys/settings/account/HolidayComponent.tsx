import { update } from "@/routes/manager/phys/settings/account/holiday";
import { Label } from "@/components/ui/label";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { useForm } from "@inertiajs/react";
import InputError from "@/components/app/form/InputError";
import { router } from "@inertiajs/react";
import {usePage} from "@inertiajs/react";
import DatePickerGroup from "@/components/app/form/DatePickerGroup";
import { parseDate } from "@/helpers/dateHelper";

interface IProps {
    holiday_from: string | null;
    holiday_to: string | null;
}

export default function ({holiday_from, holiday_to}: IProps) {
    const { errors } = usePage().props;
    const { data, setData } = useForm({
        holidayFrom: parseDate(holiday_from),
        holidayTo: parseDate(holiday_to),
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
            <DatePickerGroup
                label='От'
                value={data.holidayFrom}
                onChange={(date) => handleDateChange('holidayFrom', date)}
                error={errors.holidayFrom}
            />
            <DatePickerGroup
                label='До'
                value={data.holidayTo}
                onChange={(date) => handleDateChange('holidayTo', date)}
                error={errors.holidayTo}
            />
        </section>
    );
}
