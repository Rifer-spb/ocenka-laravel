export type TUserEvent = {
    type: 'call';
    data: Record<string, any>;
};

type TProps = {
    event: TUserEvent;
};

export default function WebSocketRenderer({ event }: TProps) {
    switch (event.type) {
        case 'call':
            return (
                <>{ event.data.action } | { event.data.callId }</>
            );

        default:
            return null;
    }
}
