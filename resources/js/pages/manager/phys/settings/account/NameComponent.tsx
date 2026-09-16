import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import { update } from "@/routes/manager/phys/settings/account/name";
import {Button} from "@/components/ui/button";
import {IProfile} from "./account.types";
import InputError from "@/components/app/form/InputError";
import AppForm from "@/components/app/form/AppForm";

interface IProps {
    profile: IProfile;
}

export default function ({ profile }: IProps) {
    return (
        <section style={{maxWidth: '500px'}}>
            <h2>Мои данные</h2>
            <AppForm {...update.form()}>
                {({errors}) => (
                    <>
                        <div className="form-group">
                            <Label htmlFor="firstName">Фамилия</Label>
                            <Input
                                id="firstName"
                                type="text"
                                name="firstName"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="firstName"
                                className="form-control"
                                defaultValue={profile.first_name ?? undefined}
                            />
                            <InputError message={errors.firstName} />
                        </div>
                        <div className="form-group">
                            <Label htmlFor="secondName">Имя</Label>
                            <Input
                                id="secondName"
                                type="text"
                                name="secondName"
                                required
                                autoFocus
                                tabIndex={2}
                                autoComplete="secondName"
                                className="form-control"
                                defaultValue={profile.second_name ?? undefined}
                            />
                            <InputError message={errors.secondName} />
                        </div>
                        <div className="form-group">
                            <Label htmlFor="lastName">Отчество</Label>
                            <Input
                                id="lastName"
                                type="text"
                                name="lastName"
                                required
                                autoFocus
                                tabIndex={3}
                                autoComplete="lastName"
                                className="form-control"
                                defaultValue={profile.last_name ?? undefined}
                            />
                            <InputError message={errors.lastName} />
                        </div>
                        <div className="form-group">
                            <Button
                                type="submit"
                                tabIndex={4}
                                className="btn btn-primary"
                            >Сохранить</Button>
                        </div>
                    </>
                )}
            </AppForm>
        </section>
    );
}


