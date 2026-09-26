import InertiaForm from "@/components/app/form/InertiaForm";
import {updateTemplate} from "@/routes/manager/legal/settings/registry";
import InputGroup from "@/components/app/form/InputGroup";
import Button from "@/components/app/form/Button";

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
            <InertiaForm {...updateTemplate.form()}>
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
