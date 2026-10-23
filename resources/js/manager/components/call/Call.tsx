import './Call.css';
import {useEffect, useState} from "react";
import { TCall } from "@manager/types";
import CallTabs from "./CallTabs";
import CurrentCall from "./CurrentCall";

type TProps = {
    calls: TCall[];
};

export default function ({ calls } : TProps) {
    const [currentCall, setCurrentCall] = useState<TCall | null>(null);

    const handleSelectCall = (e: any, call: TCall) => {
        e.preventDefault;
        setCurrentCall(call);
    };

    useEffect(() => {
        if (!currentCall) {
            setCurrentCall(calls[0]);
        }
    }, [calls]);

    return !currentCall ? null : (
        <div className='call-overlay'>
            <div className='call'>
                <h1>Входящий звонок</h1>
                <CallTabs currentCall={currentCall} calls={calls} handleSelectTab={handleSelectCall}>
                    <CurrentCall call={currentCall}/>
                </CallTabs>
            </div>
        </div>
    );
}
