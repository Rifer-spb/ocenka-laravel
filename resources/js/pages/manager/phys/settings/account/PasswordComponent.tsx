import Button from "@/components/app/form/Button";
import { update } from "@/routes/manager/phys/settings/account/password";
import InertiaForm from "@/components/app/form/InertiaForm";
import InputGroup from "@/components/app/form/InputGroup";

export default () => (
    <section style={{ maxWidth: '400px' }}>
        <h2>Изменение пароля</h2>
        <InertiaForm {...update.form()} resetOnSuccess={true}>
            {({ errors }) => (
                <>
                    <InputGroup
                        label='Старый пароль'
                        id="oldPassword"
                        name="oldPassword"
                        type="password"
                        tabIndex={1}
                        error={errors.oldPassword}
                    />
                    <InputGroup
                        label='Новый пароль'
                        id="newPassword"
                        name="newPassword"
                        type="password"
                        tabIndex={2}
                        error={errors.newPassword}
                    />
                    <Button className="btn-success" type="submit">Сохранить</Button>
                </>
            )}
        </InertiaForm>
    </section>
);
