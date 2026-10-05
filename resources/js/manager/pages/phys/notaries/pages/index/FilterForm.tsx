import InputGroup from "@common/components/form/InputGroup";
import CheckboxGroup from "@common/components/form/CheckboxGroup";
import { index } from "@managerRoutes/phys/notaries";
import InertiaForm from "@common/components/form/InertiaForm";
import SelectGroup from "@common/components/form/SelectGroup";
import {TSelectOptions} from "@common/types/types";

type TProps = {
    regions: TSelectOptions;
    defaultRegionId: number;
}

export default function ({ regions, defaultRegionId } : TProps) {
    return (
        <InertiaForm {...index.form()} onChange={true}>
            {({ errors, fromQuery }) => (
                <div className='filter-form table'>
                    <div className='tr'>
                        <div className='td'>
                            <SelectGroup
                                name='regionId'
                                options={regions}
                                placeholder='Выберите регион'
                                defaultValue={fromQuery('regionId') ?? defaultRegionId}
                            />
                        </div>
                        <div className='td'>
                            <InputGroup name='name' placeholder='ФИО' error={errors.name} defaultValue={fromQuery('name')}/>
                        </div>
                        <div className='td'>
                            <InputGroup name='address' placeholder='Адрес' error={errors.address} defaultValue={fromQuery('address')}/>
                        </div>
                        <div className='td'>
                            <InputGroup name='email' placeholder='E-mail' error={errors.email} defaultValue={fromQuery('email')}/>
                        </div>
                        <div className='td'>
                            <CheckboxGroup name='notWork' label='Показывать недействующих' defaultChecked={fromQuery('notWork') === '1'}/>
                        </div>
                    </div>
                </div>
            )}
        </InertiaForm>
    );
}
