import AppLayout from "@/layouts/appManagerLayout";
import { Head } from '@inertiajs/react';
import InertiaForm from "@/components/app/form/InertiaForm";
import styles from "./signUp.module.css";
import { signUp } from "@/routes/manager/auth";
import Button from "@/components/app/form/Button";
import InputGroup from "@/components/app/form/InputGroup";
import RadioGroup from "@/components/app/form/RadioGroup";

export default function SignUp() {
    return (
        <AppLayout>
            <div className={styles.singUp}>
                <InertiaForm {...signUp.form()} resetOnSuccess={true}>
                    {({ errors }) => (
                        <>
                            <Head title="Регистрация" />
                            <h1>Регистрация</h1>
                            <InputGroup
                                type="email"
                                name="email"
                                label='Ваш e-mail'
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="email"
                                placeholder="email@example.com"
                                className="form-control"
                                error={errors.email}
                            />
                            <InputGroup
                                type="password"
                                name="password"
                                label='Придумайте пароль'
                                required
                                autoFocus
                                tabIndex={2}
                                autoComplete="password"
                                placeholder="Password"
                                className="form-control"
                                error={errors.password}
                            />
                            <RadioGroup
                                name='role'
                                defaultValue='phys'
                                error={errors.role}
                                options={[
                                    { value: 'phys', label: 'Регистрация нового физического лица (сотрудника)' },
                                    { value: 'legal', label: 'Регистрация нового юридического лица' },
                                ]}
                            />
                            <Button type="submit" className="btn-success">Зарегистрироваться</Button>
                        </>
                    )}
                </InertiaForm>
            </div>
        </AppLayout>
    );
}
