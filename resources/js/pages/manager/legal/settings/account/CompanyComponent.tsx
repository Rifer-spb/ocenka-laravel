import { Form } from "@inertiajs/react";
import {TCompany, TType} from "./types";
import {Label} from "@/components/ui/label";
import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import {Input} from "@/components/ui/input";

export default ({ types, company } : { types: TType[], company: TCompany }) => (
    <section className="company">
        <h2>Компания</h2>
        <Form>
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
                        <Input type="text" name="fullName"/>
                        <InputError message={errors.fullName}/>
                    </div>
                    <div className="form-group">
                        <Label>Краткое наименование</Label>
                        <Input type="text" name="shortName"/>
                        <InputError message={errors.shortName}/>
                    </div>
                    <div className="form-group">
                        <Label>Краткое название (аббревиатура)</Label>
                        <Input type="text" name="abbr"/>
                        <InputError message={errors.abbr}/>
                    </div>
                    <div className="form-group">
                        <Label>Местонахождение</Label>
                        <Input type="text" name="address"/>
                        <InputError message={errors.address}/>
                    </div>
                    <div className="form-group">
                        <div className="row">
                            <div className="col-sm-6">
                                <Label>ИНН</Label>
                                <Input type="text" name="inn"/>
                                <InputError message={errors.inn}/>
                            </div>
                            <div className="col-sm-6">
                                <Label>КПП</Label>
                                <Input type="text" name="kpp"/>
                                <InputError message={errors.kpp}/>
                            </div>
                        </div>
                    </div>
                    <div className="form-group">
                        <div className="row">
                            <div className="col-sm-6">
                                <Label>ОРГН</Label>
                                <Input type="text" name="orgn"/>
                                <InputError message={errors.ogrn}/>
                            </div>
                            <div className="col-sm-6">
                                <Label>Дата присвоения ОРГН</Label>
                                <Input type="text" name="dateOgrn"/>
                                <InputError message={errors.dateOgrn}/>
                            </div>
                        </div>
                    </div>
                    <div className="form-group">
                        <Button type="submit" className="btn btn-primary">Сохранить</Button>
                    </div>
                </>
            )}
        </Form>
    </section>
);
