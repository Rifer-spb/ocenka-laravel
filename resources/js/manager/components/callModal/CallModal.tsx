import './CallModal.css';
import React, {useState} from "react";
import { TCall } from "./types";
import CallTabs from "./CallTabs";
import CurrentCall from "./currentCall/CurrentCall";
import Button from "@common/components/form/Button";
import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import { faWindowClose } from "@fortawesome/free-solid-svg-icons";

type TProps = {
    calls: TCall[];
    handleClose: () => void;
};

export default function CallModal({ calls, handleClose } : TProps) {
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
                <Button type="button" className='call-modal-close-btn' onClick={handleClose}>
                    <FontAwesomeIcon icon={faWindowClose}/>
                </Button>
            </div>
        </div>
    );
}
