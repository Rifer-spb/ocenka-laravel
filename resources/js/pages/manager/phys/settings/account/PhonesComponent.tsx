import { Form } from "@inertiajs/react";
import { create } from "@/routes/manager/phys/settings/account/phones";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import InputError from "@/components/input-error";
import { IPhones } from "./account.types";
import { useManagerRoute } from "@/hooks/useAppRoute";
import { faTrash } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

interface IProps {
    phones: IPhones[];
}

export default function ({ phones }: IProps) {
    const route = useManagerRoute();

    return (
        <section className="phones">
            <h2>Номера телефонов</h2>
            <Form {...create.form()} resetOnSuccess={true}>
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
                        <InputError message={errors.phone} className="error" />
                    </div>
                )}
            </Form>
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
