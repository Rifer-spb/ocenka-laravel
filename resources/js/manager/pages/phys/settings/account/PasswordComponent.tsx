import Button from "@common/components/form/Button";
import { update } from "@managerRoutes/phys/profile/password";
import InertiaForm from "@common/components/form/InertiaForm";
import InputGroup from "@common/components/form/InputGroup";

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
