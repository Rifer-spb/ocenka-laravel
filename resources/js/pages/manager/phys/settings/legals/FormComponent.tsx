import { Form } from "@inertiajs/react";
import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/input-error";
import {Button} from "@/components/ui/button";
import { create } from "@/routes/manager/phys/settings/legals";

export default function() {
    console.log(create.form());

    return (
        <Form {...create.form()} style={{ maxWidth: '550px' }}>
            {({ errors }: any) => (
                <>
                    <div className="form-group">
                        <Label htmlFor="email">E-mail адрес Юр.лица</Label>
                        <Input
                            name="email"
                            type="text"
                            required
                            style={{ backgroundColor: '#fff' }}
                        />
                        <InputError className="error" message={errors.email} />
                    </div>
                    <div className="form-group">
                        <Button className="btn btn-success" type="submit">Отправить заявку</Button>
                    </div>
                </>
            )}
        </Form>
    );
};
