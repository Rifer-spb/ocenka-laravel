import { Link } from '@inertiajs/react';

export default () => (
    <div className="navigation">
        <ul>
            <li>
                <Link href="/">Вход</Link>
            </li>
            <li>
                <Link href="/">Регистрация</Link>
            </li>
        </ul>
    </div>
);
