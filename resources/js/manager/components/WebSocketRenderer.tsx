import Call from "@manager/components/call/Call";
import { useState } from "react";
import { useEcho } from "@laravel/echo-react";

export type TUserEvent = {
    type: 'call';
    data: Record<string, any>;
};

type TProps = {
    userId: number;
}

export default function WebSocketRenderer({ userId } : TProps) {
    const [calls, setCalls] = useState([]);

    useEcho<TUserEvent>(`user.${userId}`, '.UserEvent', (event) => {
        switch (event.type) {
            case 'call':
                setCalls((prev) => [...prev, event.data.callId]);
        }
    });

    return (
        <>
            {calls.length && <Call calls={calls}/>}
        </>
    );
}
