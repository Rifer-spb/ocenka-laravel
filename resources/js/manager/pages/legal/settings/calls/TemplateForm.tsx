import InertiaForm from "@common/components/form/InertiaForm";
import InputGroup from "@common/components/form/InputGroup";
import TextareaGroup from "@common/components/form/TextareaGroup";
import Button from "@common/components/form/Button";
import { TTemplateForm } from "@manager/pages/legal/settings/calls/types";

type TProps = {
    form: TTemplateForm;
    setIsShowForm: Function;
};

export default function ({ form, setIsShowForm } : TProps) {
    return (
        <InertiaForm method={form.method} action={form.action} onSuccess={() => setIsShowForm(false)}>
            {({ errors }) => (
                <>
                    <InputGroup
                        name='name'
                        label='Название'
                        defaultValue={form.name}
                        error={errors.name}
                    />
                    <TextareaGroup
                        name='text'
                        label='Текст'
                        defaultValue={form.text}
                        error={errors.text}
                    />
                    {form.method === 'post'
                        ? <Button type='submit' className='btn-success'>Добавить</Button>
                        : <Button type='submit' className='btn-primary'>Обновить</Button>
                    }

                </>
            )}
        </InertiaForm>
    );
}
