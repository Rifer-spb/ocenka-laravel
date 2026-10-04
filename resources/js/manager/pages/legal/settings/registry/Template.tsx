import InertiaForm from "@common/components/form/InertiaForm";
import { updateRegistryTemplate } from "@managerRoutes/legal/profile";
import InputGroup from "@common/components/form/InputGroup";
import Button from "@common/components/form/Button";

type TProps = {
    template: string;
};

export default function Template({ template } : TProps) {
    return (
        <section className='template'>
            <h2>Шаблон номера договора</h2>
            <div className='info'>
                <b>ГГ, ГГГГ</b> - Год<br/>
                <b>ММ</b> - Месяц<br/>
                <b>С</b> - Счётчик<br/>
                Пример:<br/>
                ГГ-ММ-СССС ( 18-12-0002 )<br/>
                ГГГГ-ММ-ССС ( 2018-12-001 )<br/>
                По умолчанию: ССС-ГГ
            </div>
            <InertiaForm {...updateRegistryTemplate.form()}>
                {({ errors }) => (
                    <>
                        <InputGroup type='text' name='template' defaultValue={template} error={errors.template}/>
                        <Button type='submit' className='btn-primary'>Сохранить</Button>
                    </>
                )}
            </InertiaForm>
        </section>
    );
}
