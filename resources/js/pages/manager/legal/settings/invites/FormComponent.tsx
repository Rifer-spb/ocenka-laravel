import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/app/form/InputError";
import { Button } from "@/components/ui/button";
import { create } from "@/routes/manager/legal/settings/invites";
import { Form } from "@inertiajs/react";

export default function() {
    return (
        <Form style={{maxWidth: '550px'}} {...create.form()} resetOnSuccess={true}>
            {({ errors }) => (
                <>
                    <div className="form-group">
                        <Label htmlFor="email">E-mail адрес сотрудника</Label>
                        <Input
                            id="email"
                            name="email"
                            type="text"
                            required
                            style={{backgroundColor: '#fff'}}
                        />
                        <InputError message={errors.email}/>
                    </div>
                    <div className="form-group">
                        <Button className="btn btn-success" type="submit">Отправить заявку</Button>
                    </div>
                </>
            )}
        </Form>
    );
};
