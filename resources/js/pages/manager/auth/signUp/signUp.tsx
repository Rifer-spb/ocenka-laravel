import AppLayout from "@/layouts/appManagerLayout";
import { Form, Head } from '@inertiajs/react';
import styles from "./signUp.module.css";
import { signUp } from "@/routes/manager/auth";
import InputError from "@/components/input-error";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Radio } from "@/components/ui/radio";
import { Button } from "@/components/ui/button";

export default function SignUp() {
    return (
        <AppLayout>
            <div className={styles.singUp}>
                <Form {...signUp.form()} resetOnSuccess={true}>
                    {({ errors }) => (
                        <>
                            <Head title="Регистрация" />
                            <h1>Регистрация</h1>
                            <div className={styles.formGroup}>
                                <Label htmlFor="email">Ваш e-mail</Label>
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
                                <InputError message={errors.email} className="error" />
                            </div>
                            <div className={styles.formGroup}>
                                <Label htmlFor="password">Придумайте пароль</Label>
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
                                <InputError message={errors.password} className="error" />
                            </div>
                            <div className={styles.formGroup}>
                                <div>
                                    <Radio
                                        id="role"
                                        name="role"
                                        value="phys"
                                        tabIndex={3}
                                    />
                                    <Label>Регистрация нового физического лица (сотрудника)</Label>
                                </div>
                                <div>
                                    <Radio
                                        id="role"
                                        name="role"
                                        value="legal"
                                        tabIndex={4}
                                    />
                                    <Label>Регистрация нового юридического лица</Label>
                                </div>
                                <InputError message={errors.role} className="error" />
                            </div>
                            <div className={styles.formGroup}>
                                <Button
                                    type="submit"
                                    tabIndex={5}
                                    className="btn btn-success"
                                >Зарегистрироваться</Button>
                            </div>
                        </>
                    )}
                </Form>
            </div>
        </AppLayout>
    );
}
