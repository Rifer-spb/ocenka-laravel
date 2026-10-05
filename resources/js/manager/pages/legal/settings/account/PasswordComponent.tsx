import InertiaForm from "@common/components/form/InertiaForm";
import { update } from "@managerRoutes/legal/profile/password";
import InputGroup from "@common/components/form/InputGroup";
import Button from "@common/components/form/Button";

export default () => (
    <section style={{ maxWidth: '400px' }}>
        <h2>Изменение пароля</h2>

        <InertiaForm {...update.form()}>
            {({ errors }) => (
                <>
                    <InputGroup
                        label='Старый пароль'
                        name='oldPassword'
                        type='password'
                        error={errors.oldPassword}
                    />
                    <InputGroup
                        label='Новый пароль'
                        name='newPassword'
                        type='password'
                        error={errors.newPassword}
                    />
                    <div className="form-group">
                        <Button type='submit'>Сохранить</Button>
                    </div>
                </>
            )}
        </InertiaForm>
    </section>
);
