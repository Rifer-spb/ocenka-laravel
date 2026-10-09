import InertiaForm from "@common/components/form/InertiaForm";
import MultiInputGroup from "@common/components/form/MultiInputGroup";
import { updateNotary } from "@managerRoutes/phys/notaries";
import {TCurrentNotary} from "./types";
import InputGroup from "@common/components/form/InputGroup";
import SelectGroup from "@common/components/form/SelectGroup";
import TextareaGroup from "@common/components/form/TextareaGroup";
import Button from "@common/components/form/Button";

type TProps = {
    notary: TCurrentNotary;
};

const arrayErrors = (errors: Record<string, string>, name: string): Record<number, string> =>
    Object.fromEntries(
        Object.entries(errors)
            .filter(([key]) => key.startsWith(`${name}.`))
            .map(([key, msg]) => [Number(key.split('.')[1]), msg])
    );

export default function EditForm({ notary }: TProps) {
    return (
        <InertiaForm {...updateNotary.form(notary.id)}>
            {({ errors }) => (
                <>
                    <MultiInputGroup
                        name='emails'
                        label='E-mails'
                        defaultValue={notary.emails}
                        error={errors.emails}
                        itemErrors={arrayErrors(errors, 'emails')}
                    />
                    <InputGroup
                        name='site'
                        label='Сайт'
                        defaultValue={notary.site}
                        error={errors.site}
                    />
                    <SelectGroup
                        name="useDigitalReport"
                        label='Принимают электронный отчет'
                        placeholder={false}
                        defaultValue={notary.useDigitalReport}
                        error={errors.useDigitalReport}
                        options={[
                            {value: '', label: 'Не знаем'},
                            {value: 1, label: 'Принимает'},
                            {value: 0, label: 'Не принимает'},
                        ]}
                    />
                    <TextareaGroup
                        name='comment'
                        label='Комментарий'
                        defaultValue={notary.comment}
                        error={errors.comment}
                    />
                    <Button type='submit'>Сохранить</Button>
                </>
            )}
        </InertiaForm>
    );
}
