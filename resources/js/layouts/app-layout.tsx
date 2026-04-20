import AppGuestHeader from '@/components/app/header/app-guest-header';
import AppUserHeader from '@/components/app/header/app-user-header';
import { usePage } from "@inertiajs/react";
import { Auth } from "@/types";

export default function ({ children } : { children: any }) {
    const { auth } = usePage<{ auth: Auth }>().props;

    return (
        <div className="layout">
            { auth.isAuthenticated ? <AppUserHeader/> : <AppGuestHeader/> }
            <main>
                {children}
            </main>
        </div>
    );
};
