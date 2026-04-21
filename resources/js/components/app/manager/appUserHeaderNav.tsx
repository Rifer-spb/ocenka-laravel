import {usePage} from "@inertiajs/react";
import {Auth} from "@/types";
import { Link } from "@inertiajs/react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCog, faBars } from '@fortawesome/free-solid-svg-icons';
import styles from './appUserHeaderNav.module.css';

export default function () {
    const { auth } = usePage<{ auth: Auth }>().props;

    return (
        <div className={styles.navigation}>
            <ul className={styles.ul}>
                <li className={styles.li}>
                    <Link href={`/manager/${auth.user.role}/setting`} className={styles.a}>
                        <FontAwesomeIcon icon={faCog} className={styles.svg} />
                    </Link>
                </li>
                <li className={styles.li}>
                    <Link href={`/manager/${auth.user.role}/home`} className={styles.a}>
                        <FontAwesomeIcon icon={faBars} className={styles.svg} />
                    </Link>
                </li>
                <li className={styles.li}>{ auth.user.email }</li>
            </ul>
        </div>
    );
}
