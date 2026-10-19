import { usePage } from "@inertiajs/react";
import {SharedData} from "@manager/types";
import AppGuestHeader from '@manager/components/appGuestHeader';
import AppUserHeader from '@manager/components/appUserHeader';
import AppMain from "@manager/components/appMain";
import { useState, useEffect } from "react";
import { useEcho } from '@laravel/echo-react';
import toast from "react-hot-toast";
import '../../../css/manager.css';
import WebSocketRenderer, { type TUserEvent } from "@manager/components/WebSocketRenderer";

export default function ({ children } : { children: any }) {
    const { auth, flash } = usePage<SharedData>().props;
    const [event, setEvent] = useState<TUserEvent | null>(null);

    if (auth.user) {
        useEcho<TUserEvent>(`user.${auth.user.id}`, '.UserEvent', (data) => setEvent(data));
    }

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
                    {event && <WebSocketRenderer event={event}/>}
                </> :
                <>
                    <AppGuestHeader/>
                    <main>{children}</main>
                </>
            }

        </div>
    );
};
