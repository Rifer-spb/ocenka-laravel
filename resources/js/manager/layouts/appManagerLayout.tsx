import { usePage } from "@inertiajs/react";
import {SharedData} from "@manager/types";
import AppGuestHeader from '@manager/components/appGuestHeader';
import AppUserHeader from '@manager/components/appUserHeader';
import AppMain from "@manager/components/appMain";
import {useEffect} from "react";
import toast from "react-hot-toast";
import '../../../css/manager.css';

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
