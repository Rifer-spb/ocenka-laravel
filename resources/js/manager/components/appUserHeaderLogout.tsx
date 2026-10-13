import { Link } from '@inertiajs/react';
import { usePage } from '@inertiajs/react';
import { TAuth } from "@manager/types";
import styles from './appUserHeaderLogout.module.css';

export default function () {
    const { auth } = usePage<{ auth: TAuth }>().props;

    return (
        <div className={styles.auth}>
            <ul>
                <li className={styles.li}>
                    <Link
                        href={'/auth/logout'}
                        method="post"
                        as="button"
                        className={styles.a}
                    >Выход <span className={styles.name}>({ auth.user.email})</span></Link>
                </li>
            </ul>
        </div>
    );
}
