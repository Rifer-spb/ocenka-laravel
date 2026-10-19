import Button from "@common/components/form/Button";
import Modal from "@manager/components/common/modal/Modal";
import TemplateForm from "@manager/pages/legal/settings/call/TemplateForm";
import {useState} from "react";
import { create as createTemplate } from "@managerRoutes/legal/callTemplates";
import { update as updateTemplate } from "@managerRoutes/legal/callTemplates";
import { deleteMethod as deleteTemplate } from "@managerRoutes/legal/callTemplates";
import { router } from "@inertiajs/react";
import { TTemplate, TTemplateForm } from './types';

export default function({ templates } : { templates: TTemplate[] }) {
    const [isShowForm, setIsShowForm] = useState<boolean>(false);
    const [templateForm, setTemplateForm] = useState<TTemplateForm>({
        method: 'post',
        action: '',
        name: '',
        text: '',
    });

    const handleShowNewForm = () => {
        setTemplateForm({method: 'post', action: createTemplate.url(), name: '', text: ''});
        setIsShowForm(true);
    };

    const handleShowEditForm = (template: TTemplate) => {
        setTemplateForm({
            method: 'patch',
            action: updateTemplate.url(template.id),
            name: template.name,
            text: template.text
        });
        setIsShowForm(true);
    };

    const handleDelete = (id: number) => {
        if (confirm('Точно удалить?')) {
            router.delete(deleteTemplate.url(id));
        }
    };

    return (
        <>
            <Button
                type='button'
                className='btn-primary new-button'
                onClick={handleShowNewForm}
            >Добавить новый шаблон</Button>

            {templates.length ?
                <div className='table'>
                    <div className='tr tr-default'>
                        <div className='th'>Название</div>
                        <div className='th'>Текст</div>
                        <div className='th action'>Действие</div>
                    </div>
                    {templates.map((template, index) =>
                        <div key={index} className='tr tr-default'>
                            <div className='td'>{ template.name }</div>
                            <div className='td'>{ template.text }</div>
                            <div className='td'>
                                <Button
                                    type='button'
                                    className='btn-primary'
                                    onClick={() => handleShowEditForm(template)}
                                >Редактировать</Button>
                                <Button
                                    type='button'
                                    className='btn-danger'
                                    onClick={() => handleDelete(template.id)}
                                >Удалить</Button>
                            </div>
                        </div>
                    )}
                </div> : <div>Шаблонов не найдено</div>
            }

            <Modal title='Добавление шаблона' isShow={isShowForm} onChange={setIsShowForm}>
                <TemplateForm form={templateForm} setIsShowForm={setIsShowForm}/>
            </Modal>
        </>
    );
}
