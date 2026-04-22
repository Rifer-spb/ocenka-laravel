import styles from './appMainSideBar.module.css';
import {usePage} from "@inertiajs/react";
import {Auth} from "@/types";
import {useEffect, useState} from "react";
import { Link } from "@inertiajs/react";

interface MenuItem {
    route: string;
    name: string;
}

export default function () {
    const {auth} = usePage<{ auth: Auth }>().props;
    const role = auth.user.role;
    const pathname = window.location.pathname;
    const [items, setItems] = useState<MenuItem[]>([]);

    const getPhysItems = () => {
        if (pathname === '/manager/phys/settings') {
            return [
                {route: '/manager/phys/settings/account', name: 'Аккаунт'},
                {route: '/manager/phys/settings/legals', name: 'Юр. лица'},
                {route: '/manager/phys/settings/telegram', name: 'Телеграм'},
            ];
        }

        return [
            {route: '/manager/phys/notaries', name: 'Нотариусы'},
            {route: '/manager/phys/calls', name: 'Реестр звонков'},
            {route: '/manager/phys/contacts', name: 'Контакты'},
            {route: '/manager/phys/chats', name: 'Чаты'},
            {route: '/manager/phys/pre-orders', name: 'Предзаказы'},
            {route: '/manager/phys/orders', name: 'Заказы'},
            {route: '/manager/phys/registry', name: 'Договора'},
            {route: '/manager/phys/rides', name: 'Выезды'},
            {route: '/manager/phys/wait-document', name: 'Ждут документы'},
            {route: '/manager/phys/reports', name: 'Отчеты'},
            {route: '/manager/phys/check-reports', name: 'Проверка отчетов'},
            {route: '/manager/phys/client-notify', name: 'Уведомление заказчика'},
            {route: '/manager/phys/sign-ecp', name: 'Подпись ЭЦП'},
            {route: '/manager/phys/wait-confirm', name: 'Ждут подтверждения'},
            {route: '/manager/phys/print-reports', name: 'Печать сшивка'},
            {route: '/manager/phys/coordinate', name: 'Согласовать получение'},
            {route: '/manager/phys/wait-office', name: 'Отчет ждет в офисе'},
            {route: '/manager/phys/delivery', name: 'Передача в доставку'},
            {route: '/manager/phys/delivery-complete', name: 'Ждут подтв. доставки'},
            {route: '/manager/phys/complete', name: 'Завершение'},
            {route: '/manager/phys/monitoring', name: 'Мониторинг'},
            {route: '/manager/phys/resources', name: 'Ресурсы'},
            {route: '/manager/phys/client-log', name: 'Лог заказчика'}
        ];
    };

    useEffect(() => {
        if (role === 'phys') {
            setItems(getPhysItems());
        }
    }, [pathname]);

    return (
        <div className={`td ${styles.sideBar}`}>
            <div className={styles.menuTitle}>Навигация</div>
            <div className={styles.menu}>
                <ul className={styles.menuList}>
                    {items.map((item, index) => (
                        <li key={index} className={styles.menuItem}>
                            <Link href={item.route}>{item.name}</Link>
                        </li>
                    ))}
                </ul>
            </div>
        </div>
    );
}
