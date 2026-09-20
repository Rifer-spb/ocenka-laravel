import InertiaForm from "@/components/app/form/inertia/InertiaForm";
import {TCompany, TType} from "./types";
import {Label} from "@/components/ui/label";
import InputError from "@/components/app/form/InputError";
import { Button } from "@/components/ui/button";
import {Input} from "@/components/ui/input";
import { update } from "@/routes/manager/legal/settings/account/company";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { useState } from "react";

export default function ({ types, company } : { types: TType[], company: TCompany }) {
    const [dateOgrn, setDateOgrn] = useState<Date | null>(
        company.dateOgrn ? new Date(company.dateOgrn) : null
    );

    return (
        <section className="company">
            <h2>Компания</h2>
            <InertiaForm {...update.form()}>
                {({ errors }) => (
                    <>
                        <div className="form-group">
                            <Label>Организационная форма</Label>
                            <select
                                name="typeId"
                                defaultValue={company.typeId ?? ''}
                                className="form-control"
                            >
                                <option value="">Выберите тип</option>
                                {types.map(type => (
                                    <option key={type.id} value={type.id}>
                                        {type.name}
                                    </option>
                                ))}
                            </select>
                            <InputError message={errors.type}/>
                        </div>
                        <div className="form-group">
                            <Label>Полное наименование</Label>
                            <Input type="text" name="fullName" defaultValue={company.fullName ?? undefined}/>
                            <InputError message={errors.fullName}/>
                        </div>
                        <div className="form-group">
                            <Label>Краткое наименование</Label>
                            <Input type="text" name="shortName" defaultValue={company.shortName ?? undefined}/>
                            <InputError message={errors.shortName}/>
                        </div>
                        <div className="form-group">
                            <Label>Краткое название (аббревиатура)</Label>
                            <Input type="text" name="abbr" defaultValue={company.abbr ?? undefined}/>
                            <InputError message={errors.abbr}/>
                        </div>
                        <div className="form-group">
                            <Label>Местонахождение</Label>
                            <Input type="text" name="address" defaultValue={company.address ?? undefined}/>
                            <InputError message={errors.address}/>
                        </div>
                        <div className="form-group">
                            <div className="row">
                                <div className="col-sm-6">
                                    <Label>ИНН</Label>
                                    <Input type="text" name="inn" defaultValue={company.inn ?? undefined}/>
                                    <InputError message={errors.inn}/>
                                </div>
                                <div className="col-sm-6">
                                    <Label>КПП</Label>
                                    <Input type="text" name="kpp" defaultValue={company.kpp ?? undefined}/>
                                    <InputError message={errors.kpp}/>
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <div className="row">
                                <div className="col-sm-6">
                                    <Label>ОРГН</Label>
                                    <Input type="text" name="ogrn" defaultValue={company.ogrn ?? undefined}/>
                                    <InputError message={errors.ogrn}/>
                                </div>
                                <div className="col-sm-6">
                                    <Label>Дата присвоения ОРГН</Label>
                                    <DatePicker
                                        name="dateOgrn"
                                        selected={dateOgrn}
                                        placeholderText="Выберите дату"
                                        showMonthDropdown
                                        dropdownMode="select"
                                        dateFormat="dd.MM.yyyy"
                                        showMonthYearDropdown={true}
                                        className="form-control"
                                        onSelect={(date: Date | null) => setDateOgrn(date)}
                                    />
                                    <InputError message={errors.dateOgrn}/>
                                </div>
                            </div>
                        </div>
                        <div className="form-group">
                            <Button type="submit" className="btn btn-primary">Сохранить</Button>
                        </div>
                    </>
                )}
            </InertiaForm>
        </section>
    );
};
