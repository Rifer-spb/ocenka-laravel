import Input from "@/components/app/form/Input";
import Checkbox from "@/components/app/form/Checkbox";
import { index } from "@/routes/manager/phys/notaries";
import Form from "@/components/app/form/AppForm";
import Select from "@/components/app/form/Select";

type TProps = {
    regions: Record<number, string>;
}

export default function ({ regions } : TProps) {
    return (
        <Form {...index.form()} onChange={true}>
            {({ errors }) => (
                <div className='filter-form table'>
                    <div className='tr'>
                        <div className='td'>
                            <Select name='regionId' options={regions} defaultOptionName='Выберите регион'/>
                        </div>
                        <div className='td'>
                            <Input name='name' placeholder='ФИО' error={errors.name}/>
                        </div>
                        <div className='td'>
                            <Input name='address' placeholder='Адрес' error={errors.address}/>
                        </div>
                        <div className='td'>
                            <Input name='email' placeholder='E-mail' error={errors.email}/>
                        </div>
                        <div className='td'>
                            <Checkbox name='notWork' label='Показывать недействующих'/>
                        </div>
                    </div>
                </div>
            )}
        </Form>
    );
}
