import { Form } from "@inertiajs/react";
import { Input } from "@common/components/ui/input";
import InputError from "@common/components/form/InputError";
import { Button } from "@common/components/ui/button";
import { Label } from "@common/components/ui/label";
import { update } from "@managerRoutes/legal/profile/password";

export default () => (
    <section style={{ maxWidth: '400px' }}>
        <h2>Изменение пароля</h2>

        <Form {...update.form()}>
            {({ errors }) => (
                <>
                    <div className="form-group">
                        <Label htmlFor="oldPassword">Старый пароль</Label>
                        <Input
                            id="oldPassword"
                            name="oldPassword"
                            type="password"
                            tabIndex={1}
                            className="form-control"
                        />
                        <InputError message={errors.oldPassword}/>
                    </div>
                    <div className="form-group">
                        <Label htmlFor="newPassword">Новый пароль</Label>
                        <Input
                            id="newPassword"
                            name="newPassword"
                            type="password"
                            tabIndex={2}
                            className="form-control"
                        />
                        <InputError message={errors.newPassword}/>
                    </div>
                    <div className="form-group">
                        <Button className="btn btn-success" type="submit">Сохранить</Button>
                    </div>
                </>
            )}
        </Form>
    </section>
);
