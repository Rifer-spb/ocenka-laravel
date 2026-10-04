import InertiaForm from "@/components/app/form/InertiaForm";
import MultiInputGroup from "@/components/app/form/MultiInputGroup";
import { updateNotary } from "@/routes/manager/phys/notaries";
import {TCurrentNotary} from "@/pages/manager/phys/notaries/pages/index/types";
import InputGroup from "@/components/app/form/InputGroup";
import SelectGroup from "@/components/app/form/SelectGroup";
import TextareaGroup from "@/components/app/form/TextareaGroup";
import Button from "@/components/app/form/Button";

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
                    <Button type='submit' className='btn-primary'>Сохранить</Button>
                </>
            )}
        </InertiaForm>
    );
}
