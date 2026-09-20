import AppLayout from "@/layouts/appManagerLayout";
import { Head } from '@inertiajs/react';
import InertiaForm from "@/components/app/form/InertiaForm";
import styles from "./signIn.module.css";
import { signIn } from "@/routes/manager/auth";
import Button from "@/components/app/form/Button";
import { Link } from "@inertiajs/react";
import { useManagerRoute } from "@/hooks/useAppRoute";
import InputGroup from "@/components/app/form/InputGroup";

export default function SignIn() {
    const route = useManagerRoute();

    return (
        <AppLayout>
            <div className={styles.signIn}>
                <InertiaForm {...signIn.form()} resetOnSuccess={true}>
                    {({ errors }) => (
                        <>
                            <Head title="Авторизация"/>
                            <h1>Авторизация</h1>
                            <InputGroup
                                label='E-mail'
                                type="email"
                                name="email"
                                required
                                autoFocus
                                tabIndex={1}
                                autoComplete="email"
                                placeholder="email@example.com"
                                className="form-control"
                                error={errors.email}
                            />
                            <InputGroup
                                label='Пароль'
                                type="password"
                                name="password"
                                required
                                autoFocus
                                tabIndex={2}
                                autoComplete="password"
                                placeholder="Password"
                                className="form-control"
                                error={errors.password}
                            />
                            <div className={styles.formGroup}>
                                <p className={styles.p}><Link href={route('auth/lostpass', false)}>Забыли пароль?</Link></p>
                                <p className={styles.p}><Link href={route('auth/sign-up', false)}>Регистрация</Link></p>
                            </div>
                            <Button type="submit" className="btn-success">Войти</Button>
                        </>
                    )}
                </InertiaForm>
            </div>
        </AppLayout>
    );
}
