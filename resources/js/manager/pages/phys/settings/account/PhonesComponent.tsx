import InertiaForm from "@common/components/form/InertiaForm";
import { create } from "@managerRoutes/phys/profile/phones";
import { Input } from "@common/components/ui/input";
import { Button } from "@common/components/ui/button";
import InputError from "@common/components/form/InputError";
import { IPhones } from "./account.types";
import { useManagerRoute } from "@manager/hooks/useAppRoute";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import {Form} from "@inertiajs/react";

interface IProps {
    phones: IPhones[];
}

export default function ({ phones }: IProps) {
    const route = useManagerRoute();

    return (
        <section className="phones">
            <h2>Номера телефонов</h2>
            <InertiaForm {...create.form()} resetOnSuccess={true}>
                {({ errors }) => (
                    <div className="form-group">
                        <div className="input-group">
                            <Input
                                id="phone"
                                name="phone"
                                type="text"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="phone"
                                className="form-control"
                                placeholder="7 (###) ###-##-##"
                            />
                            <div className="input-group-append">
                                <Button className="btn btn-success" type="submit">Добавить</Button>
                            </div>
                        </div>
                        <InputError message={errors.phone} />
                    </div>
                )}
            </InertiaForm>
            <div className="phones">
                {phones.map((item, index) => (
                    <Form
                        key={index}
                        method="delete"
                        action={route(`settings/account/phones/${item.id}`)}
                        className="item"
                    >
                        <span>{item.phone}</span>
                        <Button type="submit">
                            <FontAwesomeIcon icon={faTrash}/>
                        </Button>
                    </Form>
                ))}
            </div>
        </section>
    );
}
