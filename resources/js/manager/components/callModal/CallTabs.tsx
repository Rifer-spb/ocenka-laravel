import { TCall } from "./types";
import React from "react";

type TProps = {
    calls: TCall[];
    currentCall: TCall;
    children: React.ReactNode;
    handleSelectTab: (e: any, call: TCall) => void;
};

export default function CallTabs({ calls, currentCall, children, handleSelectTab } : TProps) {
    const getClass = (call: TCall) => {
        const classes = [];

        if(call.status.isInProcess) {
            classes.push('status-in-process');
        } else if(call.status.isCompleted) {
            classes.push('status-completed');
        }

        if(currentCall.id === call.id) {
            classes.push('active');
        }

        return classes.join(' ');
    };

    return (
        <div className='call-tabs'>
            <ul>
                {calls.map(call =>
                    <li key={call.id} className={getClass(call)}>
                        <a
                            href='#'
                            onClick={(e) => handleSelectTab(e, call)}
                        >
                            {call.legal.name}
                            {call.status.isInProcess ? (
                                <span className='status'> - разговор</span>
                            ) : call.status.isCompleted ? (
                                <span className='status'> - завершен</span>
                            ) : null}
                        </a>
                    </li>
                )}
            </ul>
            <div className="clear"></div>
            <div className='call-tabs-content'>
                {children}
            </div>
        </div>
    );
}
