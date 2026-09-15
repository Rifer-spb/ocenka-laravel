import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { TAuth } from "@/types";
import styles from './appUserHeaderLogout.module.css';
import { useManagerRoute } from "@/hooks/useAppRoute";

export default function () {
    const { auth } = usePage<{ auth: TAuth }>().props;
    const route = useManagerRoute();

    return (
        <div className={styles.auth}>
            <ul>
                <li className={styles.li}>
                    <Link
                        href={route('auth/logout', false)}
                        method="post"
                        as="button"
                        className={styles.a}
                    >Выход <span className={styles.name}>({ auth.user.email})</span></Link>
                </li>
            </ul>
        </div>
    );
}
