import { parse, isValid } from 'date-fns';

export const parseDate = (value: string | null): Date | null => {
    if (!value) return null;
    const date = parse(value, 'dd.MM.yyyy', new Date());
    return isValid(date) ? date : null;
};

const plural = (n: number, [one, few, many]: [string, string, string]): string => {
    const mod10 = n % 10;
    const mod100 = n % 100;

    if (mod10 === 1 && mod100 !== 11) return one;
    if (mod10 >= 2 && mod10 <= 4 && (mod100 < 12 || mod100 > 14)) return few;

    return many;
};

const startOfDay = (d: Date): Date =>
    new Date(d.getFullYear(), d.getMonth(), d.getDate());

export function formatRelativeDateTime(iso: string | null | undefined): string {
    if (!iso) return '';

    const date = new Date(iso);
    if (Number.isNaN(date.getTime())) return '';

    const now = new Date();

    // Разница в календарных днях (round защищает от перехода на летнее/зимнее время)
    const days = Math.round(
        (startOfDay(now).getTime() - startOfDay(date).getTime()) / 86400000
    );

    if (days <= 0) {
        // max(0, ...) защищает от небольшой разницы часов клиента и сервера
        const minutes = Math.max(0, Math.floor((now.getTime() - date.getTime()) / 60000));

        if (minutes < 1) return 'СЕГОДНЯ, ТОЛЬКО ЧТО';
        if (minutes <= 59) return `СЕГОДНЯ, ${minutes} МИН. НАЗАД`;

        const hours = Math.floor(minutes / 60);
        const restMinutes = minutes % 60;

        return `СЕГОДНЯ, ${hours} Ч. ${restMinutes} М. НАЗАД`;
    }

    if (days === 1) return 'ВЧЕРА';

    if (days <= 6) {
        return `${days} ${plural(days, ['ДЕНЬ', 'ДНЯ', 'ДНЕЙ'])} НАЗАД`;
    }

    if (days <= 23) {
        const weeks = Math.floor(days / 7);
        return `${weeks} ${plural(weeks, ['НЕДЕЛЮ', 'НЕДЕЛИ', 'НЕДЕЛЬ'])} НАЗАД`;
    }

    if (days <= 365 - 15) {
        const months = Math.max(1, Math.floor(days / 30));
        return `${months} ${plural(months, ['МЕСЯЦ', 'МЕСЯЦА', 'МЕСЯЦЕВ'])} НАЗАД`;
    }

    if (days <= 2 * 365 - 15) return 'БОЛЕЕ ГОДА НАЗАД';

    return 'БОЛЕЕ 2 ЛЕТ НАЗАД';
}

export function formatShortDateTime(iso: string | null | undefined): string {
    if (!iso) return '';

    const pad = (n: number): string => String(n).padStart(2, '0');

    const date = new Date(iso);
    if (Number.isNaN(date.getTime())) return '';

    const day = pad(date.getDate());
    const month = pad(date.getMonth() + 1);
    const hours = pad(date.getHours());
    const minutes = pad(date.getMinutes());

    return `${day}.${month} ${hours}:${minutes}`;
}
