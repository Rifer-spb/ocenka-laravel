import { create } from "@managerRoutes/legal/invites";
import InertiaForm from "@common/components/form/InertiaForm";
import InputGroup from "@common/components/form/InputGroup";
import Button from "@common/components/form/Button";

export default function() {
    return (
        <InertiaForm {...create.form()} resetOnSuccess={true} style={{maxWidth: '550px'}}>
            {({ errors }) => (
                <>
                    <InputGroup
                        name='email'
                        required
                        error={errors.email}
                        placeholder='E-mail сотрудника'
                    />
                    <Button className="btn-success" type="submit">Отправить заявку</Button>
                </>
            )}
        </InertiaForm>
    );
};
