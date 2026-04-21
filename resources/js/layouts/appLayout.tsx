import AppGuestHeader from '@/components/app/header/appGuestHeader';
import AppUserHeader from '@/components/app/header/appUserHeader';
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
