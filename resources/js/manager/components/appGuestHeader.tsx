import { Link } from "@inertiajs/react";

export default function () {
    return (
        <div className="header">
            <div className="container">
                <div className="table">
                    <div className="tr">
                        <div className="td left">
                            <div className="brand">Ocenka</div>
                        </div>
                        <div className="td center"></div>
                        <div className="td right">
                            <div className="navigation">
                                <ul>
                                    <li>
                                        <Link href={'/auth/sign-in'}>Вход</Link>
                                    </li>
                                    <li>
                                        <Link href={'/auth/sign-up'}>Регистрация</Link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="clear"></div>
            </div>
        </div>
    );
}
