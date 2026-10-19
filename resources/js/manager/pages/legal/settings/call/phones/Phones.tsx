import Form from "./Form";
import Button from "@common/components/form/Button";
import {router} from "@inertiajs/react";
import {deletePhone} from "@common/wayfinder/actions/App/Manager/Http/Controllers/Legal/ProfileController";
import { TPhone } from '../types';

type TProps = {
    phones: TPhone[];
};

export default function ({ phones } : TProps) {
    const handleDelete = (id: number) => {
        router.delete(deletePhone(id));
    };

    return (
        <div className='phones'>
            <Form />
            <div className='table'>
                {phones.map((phone, index) =>
                    <div key={index} className='tr'>
                        <div className='td'>{ phone.phone }</div>
                        <div className='td'>
                            <Button type='button' onClick={() => handleDelete(phone.id)}>Удалить</Button>
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
