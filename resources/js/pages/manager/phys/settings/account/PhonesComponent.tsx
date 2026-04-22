import { Form } from "@inertiajs/react";
import { addPhone } from "@/routes/manager/phys/settings";
import { Input } from "@/components/ui/input";
import { Button } from "@/components/ui/button";
import InputError from "@/components/input-error";
import { Phones } from "./account.types";

interface Props {
    phones: Phones
}

export default function ({ phones }: Props) {

    return (
        <section style={{ maxWidth: '400px' }}>
            <h2>Номера телефонов</h2>
            <Form {...addPhone.form()}>
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
        </section>
    );
}
