import { usePage } from "@inertiajs/react";
import {SharedData} from "@/types";
import AppGuestHeader from '@/components/app/manager/appGuestHeader';
import AppUserHeader from '@/components/app/manager/appUserHeader';
import AppMain from "@/components/app/manager/appMain";
import {useEffect} from "react";
import toast from "react-hot-toast";

export default function ({ children } : { children: any }) {
    const { auth, flash } = usePage<SharedData>().props;

    useEffect(() => {
        if (flash?.success) {
            toast.success(flash.success)
        }
        if (flash?.error) {
            toast.error(flash.error)
        }
    }, [flash]);

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
