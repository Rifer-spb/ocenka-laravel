import { Form } from "@inertiajs/react";
import { Input } from "@/components/ui/input";
import InputError from "@/components/input-error";
import { Button } from "@/components/ui/button";
import { Label } from "@/components/ui/label";
import { update } from "@/routes/manager/legal/settings/account/password";

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
                        <InputError message={errors.oldPassword} className="error"/>
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
                        <InputError message={errors.newPassword} className="error"/>
                    </div>
                    <div className="form-group">
                        <Button className="btn btn-success" type="submit">Сохранить</Button>
                    </div>
                </>
            )}
        </Form>
    </section>
);
