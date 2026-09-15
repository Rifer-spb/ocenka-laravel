import Input from "@/components/app/form/Input";
import Checkbox from "@/components/app/form/Checkbox";
import { index } from "@/routes/manager/phys/notaries";
import {useRef} from "react";
import { useCallback } from "react";
import {router, useForm} from "@inertiajs/react";
import {TFilter} from "@/pages/manager/phys/notaries/pages/index/types";

type TProps = {
    filter: TFilter;
}

function formDataToObject(form) {
    const data = Object.fromEntries(new FormData(form).entries());

    // checkbox: true/false (или 1/0, как у вас)
    form.querySelectorAll('input[type="checkbox"][name]').forEach((el) => {
        data[el.name] = el.checked ? '1' : '0';
    });

    // radio: только выбранный (в FormData и так попадает только выбранный,
    // но если ни один не выбран — ключа не будет, подставим null/пусто)
    form.querySelectorAll('input[type="radio"][name]').forEach((el) => {
        if (el.checked) {
            data[el.name] = el.value;
        } else if (!(el.name in data)) {
            data[el.name] = '';
        }
    });

    return data;
}

export default function ({ filter } : TProps) {
    const formRef = useRef<any>(null);

    const handleSubmit = useCallback(() => {
        const form = formRef.current;
        if (!form) return;

        const data = formDataToObject(form);

        router.get(index.url(), data, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
        });
    }, []);

    return (
        <form ref={formRef} onChange={handleSubmit}>
            <div className='filter-form table'>
                <div className='tr'>
                    <div className='td'>
                        <Input name='name' placeholder='ФИО' value={filter.name}/>
                    </div>
                </div>
                <div className='tr'>
                    <div className='td'>
                        <Input name='address' placeholder='Адрес' value={filter.address}/>
                    </div>
                </div>
                <div className='tr'>
                    <div className='td'>
                        <Input name='email' placeholder='E-mail' value={filter.email}/>
                    </div>
                </div>
                <div className='tr'>
                    <div className='td'>
                        <Checkbox
                            name='notWork'
                            label='показывать недействующих'
                            checked={filter.notWork}
                        />
                    </div>
                </div>
            </div>
        </form>
    );
}
