import { update } from '@managerRoutes/phys/profile/holiday';
import "react-datepicker/dist/react-datepicker.css";
import { useForm } from "@inertiajs/react";
import { router } from "@inertiajs/react";
import {usePage} from "@inertiajs/react";
import DatePickerGroup from "@common/components/form/DatePickerGroup";
import { parseDate } from "@common/helpers/dateHelper";

interface IProps {
    holidayFrom: string | null;
    holidayTo: string | null;
}

export default function ({holidayFrom, holidayTo}: IProps) {
    const { errors } = usePage().props;
    const { data, setData } = useForm({
        holidayFrom: parseDate(holidayFrom),
        holidayTo: parseDate(holidayTo),
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
