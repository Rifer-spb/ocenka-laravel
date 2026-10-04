import { Label } from "@common/components/ui/label";
import { Input } from "@common/components/ui/input";
import InputError from "@common/components/form/InputError";
import { Button } from "@common/components/ui/button";
import { create } from "@managerRoutes/phys/invites";
import { Form } from "@inertiajs/react";

export default function() {
    return (
        <Form style={{maxWidth: '550px'}} {...create.form()} resetOnSuccess={true}>
            {({ errors }) => (
                <>
                    <div className="form-group">
                        <Label htmlFor="email">E-mail адрес Юр.лица</Label>
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
