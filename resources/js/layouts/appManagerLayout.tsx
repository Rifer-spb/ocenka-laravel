import { usePage } from "@inertiajs/react";
import { Auth } from "@/types";
import AppGuestHeader from '@/components/app/manager/appGuestHeader';
import AppUserHeader from '@/components/app/manager/appUserHeader';
import AppMain from "@/components/app/manager/appMain";

export default function ({ children } : { children: any }) {
    const { auth } = usePage<{ auth: Auth }>().props;

    return (
        <div className="layout">
            { auth.isAuthenticated ?
                <>
                    <AppUserHeader/>
                    <AppMain children={children}/>
                </> :
                <>
                    <AppGuestHeader/>
                    <main>
                        {children}
                    </main>
                </>
            }

        </div>
    );
};
