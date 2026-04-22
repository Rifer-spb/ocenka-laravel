import { usePage } from '@inertiajs/react';
import { Auth } from "@/types";

export function useManagerRoute() {
    const { auth } = usePage<{ auth: Auth | null }>().props;
    const role = auth?.user?.role;

    return (path: string = '', withRole: boolean = true) => {
        const cleanPath = path.replace(/^\/+|\/+$/g, '');

        if (!role || !withRole) {
            return cleanPath ? `/manager/${cleanPath}` : `/manager/home`;
        }

        return cleanPath ? `/manager/${role}/${cleanPath}` : `/manager/${role}/home`;
    };
}

export function useClientRoute() {
    return (path: string = '') => {
        const cleanPath = path.replace(/^\/+|\/+$/g, '');
        return cleanPath ? `/client/${cleanPath}` : `/client/home`;
    };
}

export function useNotaryRoute() {
    return (path: string = '') => {
        const cleanPath = path.replace(/^\/+|\/+$/g, '');
        return cleanPath ? `/notary/${cleanPath}` : `/notary/home`;
    };
}
