import { parse, isValid } from 'date-fns';

export const parseDate = (value: string | null): Date | null => {
    if (!value) return null;
    const date = parse(value, 'dd.MM.yyyy', new Date());
    return isValid(date) ? date : null;
};
