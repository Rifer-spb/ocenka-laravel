import AppLayout from "@/layouts/app-layout";
import { Form, Head } from '@inertiajs/react';
import styles from "./signIn.module.css";
import { signIn } from "@/routes/manager/auth";
import InputError from "@/components/input-error";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Button } from "@/components/ui/button";
import { Link } from "@inertiajs/react";

export default function SignIn() {
    return (
        <AppLayout>
            <div className={styles.signIn}>
                <Form {...signIn.form()}>
                    {({ errors }) => (
                        <>
                            <Head title="Авторизация"/>
                            <h1>Авторизация</h1>
                            <div className={styles.formGroup}>
                                <Label htmlFor="email">E-mail</Label>
                                <Input
                                    id="email"
                                    type="email"
                                    name="email"
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="email"
                                    placeholder="email@example.com"
                                    className="form-control"
                                />
                                <InputError message={errors.email} className="error"/>
                            </div>
                            <div className={styles.formGroup}>
                                <Label htmlFor="password">Пароль</Label>
                                <Input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autoFocus
                                    tabIndex={2}
                                    autoComplete="password"
                                    placeholder="Password"
                                    className="form-control"
                                />
                                <InputError message={errors.password} className="error"/>
                            </div>
                            <div className={styles.formGroup}>
                                <p className={styles.p}><Link href="/manager/auth/lostpass">Забыли пароль?</Link></p>
                                <p className={styles.p}><Link href="/manager/auth/sign-up">Регистрация</Link></p>
                            </div>
                            <div className={styles.formGroup}>
                                <Button
                                    type="submit"
                                    tabIndex={5}
                                    className="btn btn-success"
                                >Войти</Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </AppLayout>
    );
}
