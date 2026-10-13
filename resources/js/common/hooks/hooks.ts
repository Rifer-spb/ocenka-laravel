import { usePage } from '@inertiajs/react';
import { useMemo } from 'react';

export function useQueryParams(): Record<string, string | string[]> {
    const { url } = usePage();
    const parseQueryParams = (url: string): Record<string, string | string[]> => {
        const queryString = url.includes('?') ? url.slice(url.indexOf('?') + 1) : '';
        const searchParams = new URLSearchParams(queryString);

        const result: Record<string, string | string[]> = {};

        for (const key of searchParams.keys()) {
            const values = searchParams.getAll(key);
            result[key] = values.length > 1 ? values : values[0];
        }

        return result;
    }

    return useMemo(() => parseQueryParams(url), [url]);
}
