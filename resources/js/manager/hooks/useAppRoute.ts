import { usePage } from '@inertiajs/react';
import {TAuth} from "@manager/types/auth";

export function useManagerRoute() {
    const { auth } = usePage<{ auth: TAuth | null }>().props;
    const role = auth?.user?.role;

    return (path: string = '', withRole: boolean = true) => {
        const cleanPath = path.replace(/^\/+|\/+$/g, '');

        if (!role || !withRole) {
            return cleanPath ? `/${cleanPath}` : `/home`;
        }

        return cleanPath ? `/${role}/${cleanPath}` : `/${role}/home`;
    };
}
