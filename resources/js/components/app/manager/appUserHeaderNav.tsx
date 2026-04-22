import {Auth} from "@/types";
import {Link, usePage} from "@inertiajs/react";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faCog, faBars } from '@fortawesome/free-solid-svg-icons';
import styles from './appUserHeaderNav.module.css';
import {useManagerRoute} from "@/hooks/useManagerRoute";

export default function () {
    const { auth } = usePage<{ auth: Auth }>().props;
    const route = useManagerRoute();

    return (
        <div className={styles.navigation}>
            <ul className={styles.ul}>
                <li className={styles.li}>
                    <Link href={route('setting')} className={styles.a}>
                        <FontAwesomeIcon icon={faCog} className={styles.svg} />
                    </Link>
                </li>
                <li className={styles.li}>
                    <Link href={route('home')} className={styles.a}>
                        <FontAwesomeIcon icon={faBars} className={styles.svg} />
                    </Link>
                </li>
                <li className={styles.li}>{ auth.user.email }</li>
            </ul>
        </div>
    );
}
