import {User} from "@/types";
import {Form} from '@inertiajs/react';
import {Label} from "@/components/ui/label";
import {Input} from "@/components/ui/input";
import InputError from "@/components/input-error";
import {updateName} from "@/routes/manager/phys/settings";
import {Button} from "@/components/ui/button";
import {Profile} from "./account.types";

interface Props {
    profile: Profile;
}

export default function ({ profile }: Props) {
    return (
        <section style={{maxWidth: '500px'}}>
            <h2>Мои данные</h2>
            <Form {...updateName.form()}>
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
                                defaultValue={profile.first_name}
                            />
                            <InputError message={errors.firstName} className="error"/>
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
                                defaultValue={profile.second_name}
                            />
                            <InputError message={errors.secondName} className="error"/>
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
                                defaultValue={profile.last_name}
                            />
                            <InputError message={errors.lastName} className="error"/>
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
            </Form>
        </section>
    );
}


