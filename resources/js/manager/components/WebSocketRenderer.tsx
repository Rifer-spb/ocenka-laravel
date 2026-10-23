import Call from "@manager/components/call/Call";
import { useState } from "react";
import { useEcho } from "@laravel/echo-react";
import { getCall } from "@managerRoutes/phys/calls";
import { getRequest } from "@common/utils/api";
import { TCall } from "@manager/types";

type TUserEvent = {
    type: 'call';
    data: Record<string, any>;
};

type TProps = {
    userId: number;
}

export default function WebSocketRenderer({ userId } : TProps) {
    const [calls, setCalls] = useState<TCall[]>([]);

    const handleAddCall = (callId: number) => {
        getRequest<{call: TCall}>(getCall.url(callId))
            .then(response => {
                setCalls((prev) => [...prev, response.data.call]);
            })
            .catch(err => console.log(err))
    }

    useEcho<TUserEvent>(`user.${userId}`, '.UserEvent', (event) => {
        if (event.type === 'call') {
            if (event.data.action === 'add') {
                handleAddCall(event.data.callId)
            }
        }
    });

    return (
        <>
            {calls.length && <Call calls={calls}/>}
        </>
    );
}
