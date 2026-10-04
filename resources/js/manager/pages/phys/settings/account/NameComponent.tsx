import { update } from "@managerRoutes/phys/profile/name";
import Button from "@common/components/form/Button";
import {IProfile} from "./account.types";
import InertiaForm from "@common/components/form/InertiaForm";
import InputGroup from "@common/components/form/InputGroup";

interface IProps {
    profile: IProfile;
}

export default function ({ profile }: IProps) {
    return (
        <section style={{maxWidth: '500px'}}>
            <h2>Мои данные</h2>
            <InertiaForm {...update.form()}>
                {() => (
                    <>
                        <InputGroup
                            label='Фамилия'
                            id="firstName"
                            type="text"
                            name="firstName"
                            autoFocus
                            tabIndex={1}
                            autoComplete="firstName"
                            className="form-control"
                            defaultValue={profile.first_name ?? undefined}
                        />
                        <InputGroup
                            label='Имя'
                            id="secondName"
                            type="text"
                            name="secondName"
                            autoFocus
                            tabIndex={2}
                            autoComplete="secondName"
                            className="form-control"
                            defaultValue={profile.second_name ?? undefined}
                        />
                        <InputGroup
                            label='Отчество'
                            id="lastName"
                            type="text"
                            name="lastName"
                            autoFocus
                            tabIndex={3}
                            autoComplete="lastName"
                            className="form-control"
                            defaultValue={profile.last_name ?? undefined}
                        />
                        <Button type="submit" className="btn-primary">Сохранить</Button>
                    </>
                )}
            </InertiaForm>
        </section>
    );
}


