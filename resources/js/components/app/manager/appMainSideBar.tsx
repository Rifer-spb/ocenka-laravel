import styles from './appMainSideBar.module.css';
import {usePage} from "@inertiajs/react";
import {TAuth} from "@/types";
import {useEffect, useState} from "react";
import { Link } from "@inertiajs/react";
import { useManagerRoute } from "@/hooks/useManagerRoute";

interface MenuItem {
    route: string;
    name: string;
}

export default function () {
    const {auth} = usePage<{ auth: TAuth }>().props;
    const role = auth.user.role;
    const pathname = window.location.pathname;
    const [items, setItems] = useState<MenuItem[]>([]);
    const route = useManagerRoute();

    const getPhysItems = () => {
        if (pathname.includes('/manager/phys/settings')) {
            return [
                {route: route('settings/account'), name: 'Аккаунт'},
                {route: route('settings/legals'), name: 'Юр. лица'},
                {route: route('settings/telegram'), name: 'Телеграм'},
            ];
        }

        return [
            {route: route('notaries'), name: 'Нотариусы'},
            {route: route('calls'), name: 'Реестр звонков'},
            {route: route('contacts'), name: 'Контакты'},
            {route: route('chats'), name: 'Чаты'},
            {route: route('pre-orders'), name: 'Предзаказы'},
            {route: route('orders'), name: 'Заказы'},
            {route: route('registry'), name: 'Договора'},
            {route: route('rides'), name: 'Выезды'},
            {route: route('wait-document'), name: 'Ждут документы'},
            {route: route('reports'), name: 'Отчеты'},
            {route: route('check-reports'), name: 'Проверка отчетов'},
            {route: route('client-notify'), name: 'Уведомление заказчика'},
            {route: route('sign-ecp'), name: 'Подпись ЭЦП'},
            {route: route('wait-confirm'), name: 'Ждут подтверждения'},
            {route: route('print-reports'), name: 'Печать сшивка'},
            {route: route('coordinate'), name: 'Согласовать получение'},
            {route: route('wait-office'), name: 'Отчет ждет в офисе'},
            {route: route('delivery'), name: 'Передача в доставку'},
            {route: route('delivery-complete'), name: 'Ждут подтв. доставки'},
            {route: route('complete'), name: 'Завершение'},
            {route: route('monitoring'), name: 'Мониторинг'},
            {route: route('resources'), name: 'Ресурсы'},
            {route: route('client-log'), name: 'Лог заказчика'}
        ];
    };

    const getLegalItems = () => {
        if (pathname.includes('/manager/legal/settings')) {
            return [
                {route: route('settings/account'), name: 'Аккаунт'},
                {route: route('settings/persons'), name: 'Сотрудники'},
            ];
        }

        return [];
    };

    useEffect(() => {
        if (role === 'phys') {
            setItems(getPhysItems());
        } else if (role === 'legal') {
            setItems(getLegalItems());
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
