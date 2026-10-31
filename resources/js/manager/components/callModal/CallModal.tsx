import './CallModal.css';
import React, {useState} from "react";
import { TCall } from "./types";
import CallTabs from "./CallTabs";
import CurrentCall from "./currentCall/CurrentCall";

type TProps = {
    calls: TCall[];
};

export default function CallModal({ calls } : TProps) {
    const [currentCallId, setCurrentCallId] = useState<number | null>(null);
    const currentCall = calls.find(c => c.id === currentCallId) ?? calls[0] ?? null;

    const handleSelectCall = (e: React.MouseEvent, call: TCall) => {
        e.preventDefault();
        setCurrentCallId(call.id);
    };

    return !currentCall ? null : (
        <div className='call-modal-overlay'>
            <div className='call-modal'>
                <h1>Входящий звонок</h1>
                <CallTabs currentCall={currentCall} calls={calls} handleSelectTab={handleSelectCall}>
                    <CurrentCall call={currentCall}/>
                </CallTabs>
            </div>
        </div>
    );
}
