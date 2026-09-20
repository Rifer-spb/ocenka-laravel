import { create } from "@/routes/manager/legal/settings/invites";
import InertiaForm from "@/components/app/form/InertiaForm";
import InputGroup from "@/components/app/form/InputGroup";
import Button from "@/components/app/form/Button";

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
