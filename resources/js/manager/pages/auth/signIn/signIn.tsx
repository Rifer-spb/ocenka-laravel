import AppLayout from "@manager/layouts/appManagerLayout";
import { Head } from '@inertiajs/react';
import InertiaForm from "@common/components/form/InertiaForm";
import styles from "./signIn.module.css";
import { signIn } from "@managerRoutes/auth";
import Button from "@common/components/form/Button";
import { Link } from "@inertiajs/react";
import InputGroup from "@common/components/form/InputGroup";

export default function SignIn() {
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
                                <p className={styles.p}><Link href={'/auth/lostpass'}>Забыли пароль?</Link></p>
                                <p className={styles.p}><Link href={'/auth/sign-up'}>Регистрация</Link></p>
                            </div>
                            <Button type="submit" className="btn-success">Войти</Button>
                        </>
                    )}
                </InertiaForm>
            </div>
        </AppLayout>
    );
}
