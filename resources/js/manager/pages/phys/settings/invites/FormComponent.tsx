import InertiaForm from "@common/components/form/InertiaForm";
import InputGroup from "@common/components/form/InputGroup";
import { create } from "@managerRoutes/phys/invites";
import Button from "@common/components/form/Button";

export default function() {
    return (
        <InertiaForm style={{maxWidth: '550px'}} {...create.form()} resetOnSuccess={true}>
            {({ errors }) => (
                <>
                    <InputGroup
                        label='E-mail адрес Юр.лица'
                        name='email'
                        required
                        error={errors.email}
                    />
                    <Button className='btn-success' type='submit'>Отправить заявку</Button>
                </>
            )}
        </InertiaForm>
    );
};
