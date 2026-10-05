import InertiaForm from "@common/components/form/InertiaForm";
import {TCompany} from "./types";
import { update } from "@managerRoutes/legal/profile/company";
import "react-datepicker/dist/react-datepicker.css";
import SelectGroup from "@common/components/form/SelectGroup";
import { TSelectOptions } from "@common/types/types";
import InputGroup from "@common/components/form/InputGroup";
import DatePickerGroup from "@common/components/form/DatePickerGroup";
import Button from "@common/components/form/Button";

export default function ({ types, company } : { types: TSelectOptions, company: TCompany }) {
    return (
        <section className="company">
            <h2>Компания</h2>
            <InertiaForm {...update.form()}>
                {({ errors }) => (
                    <>
                        <SelectGroup
                            label='Организационная форма'
                            name="typeId"
                            options={types}
                            placeholder='Выберите тип'
                            error={errors.type}
                            defaultValue={company.typeId ?? ''}
                        />
                        <InputGroup
                            label='Полное наименование'
                            name='fullName'
                            defaultValue={company.fullName ?? undefined}
                            error={errors.fullName}
                        />
                        <InputGroup
                            label='Краткое наименование'
                            name='shortName'
                            defaultValue={company.shortName ?? undefined}
                            error={errors.shortName}
                        />
                        <InputGroup
                            label='Аббревиатура'
                            name='abbr'
                            defaultValue={company.abbr ?? undefined}
                            error={errors.abbr}
                        />
                        <InputGroup
                            label='Местонахождение'
                            name='address'
                            defaultValue={company.address ?? undefined}
                            error={errors.address}
                        />
                        <div className="form-group">
                            <div className="row">
                                <div className="col-sm-6">
                                    <InputGroup
                                        label='ИНН'
                                        name='inn'
                                        defaultValue={company.inn ?? undefined}
                                        error={errors.inn}
                                    />
                                </div>
                                <div className="col-sm-6">
                                    <InputGroup
                                        label='КПП'
                                        name='kpp'
                                        defaultValue={company.kpp ?? undefined}
                                        error={errors.kpp}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <div className="row">
                                <div className="col-sm-6">
                                    <InputGroup
                                        label='ОРГН'
                                        name='ogrn'
                                        defaultValue={company.ogrn ?? undefined}
                                        error={errors.ogrn}
                                    />
                                </div>
                                <div className="col-sm-6">
                                    <DatePickerGroup
                                        label='Дата присвоения ОРГН'
                                        name='dateOgrn'
                                        defaultValue={company.dateOgrn}
                                        error={errors.dateOgrn}
                                    />
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <Button type='submit'>Сохранить</Button>
                        </div>
                    </>
                )}
            </InertiaForm>
        </section>
    );
};
