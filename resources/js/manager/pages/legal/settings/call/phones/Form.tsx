import InertiaForm from "@common/components/form/InertiaForm";
import { addPhone } from "@common/wayfinder/actions/App/Manager/Http/Controllers/Legal/ProfileController";
import Button from "@common/components/form/Button";
import InputButtonGroup from "@common/components/form/InputButtonGroup";

export default function () {
    return (
        <InertiaForm {...addPhone.form()} resetOnSuccess>
            {({ errors }) => (
                <InputButtonGroup
                    name="phone"
                    error={errors.phone}
                    button={<Button type="submit" className='btn-success'>Добавить</Button>}
                />
            )}
        </InertiaForm>
    );
}
