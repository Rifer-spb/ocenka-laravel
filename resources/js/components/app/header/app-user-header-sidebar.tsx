import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { Auth } from "@/types";

export default function () {
    const { auth } = usePage<{ auth: Auth }>().props;

    return (
        <div>
            <p>Добро пожаловать, {auth.user.name}</p>
            <Link href="/manager/auth/logout" method="post" as="button">Выйти</Link>
        </div>
    );
}
