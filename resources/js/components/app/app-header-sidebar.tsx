import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';

export default function AppHeaderSidebar() {
    const { auth } = usePage().props;
    const isAuthenticated = auth.isAuthenticated;

    return (
        <div>
            {isAuthenticated ? (
                <div>
                    <p>Добро пожаловать, {auth.user.name}</p>
                    <Link href="/manager/auth/logout">Выйти</Link>
                </div>
            ) : (
                <div className="navigation">
                    <ul>
                        <li>
                            <Link href="/">Вход</Link>
                        </li>
                        <li>
                            <Link href="/manager/auth/sign-up">Регистрация</Link>
                        </li>
                    </ul>
                </div>
            )}
        </div>
    );
}
