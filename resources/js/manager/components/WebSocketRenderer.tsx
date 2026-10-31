import CallModal from "@manager/components/callModal/CallModal";
import { TCall } from "@manager/components/callModal/types";
import { useState } from "react";
import { useEcho } from "@laravel/echo-react";
import { getCall } from "@managerRoutes/phys/calls";
import { getRequest } from "@common/utils/api";

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

    const handleDeleteCall = (callId: number) => {
        setCalls((prev) => prev.filter(c => c.id !== callId));
    }

    const handleUpdateCall = (callId: number) => {
        getRequest<{call: TCall}>(getCall.url(callId))
            .then(response => {
                const updated = response.data.call;
                setCalls((prev) => prev.map(c => c.id === updated.id ? updated : c));
            })
            .catch(err => console.log(err))
    }

    useEcho<TUserEvent>(`user.${userId}`, '.UserEvent', (event) => {
        if (event.type === 'call') {
            if (event.data.action === 'add') {
                handleAddCall(event.data.callId);
            } else if (event.data.action === 'delete') {
                handleDeleteCall(event.data.callId);
            } else if (event.data.action === 'update') {
                handleUpdateCall(event.data.callId);
            }
        }
    });

    return (
        <>
            {calls.length && <CallModal calls={calls}/>}
        </>
    );
}
