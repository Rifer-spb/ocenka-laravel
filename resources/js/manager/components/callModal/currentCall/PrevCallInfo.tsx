import { TPrevCall } from "../types";
import { formatRelativeDateTime, formatShortDateTime } from "@common/helpers/dateHelper";

type TProps = {
    prevCall?: TPrevCall;
};

export default function PrevCallInfo({ prevCall } : TProps) {
    return (
        <div className='table prev-call-info'>
            <div className='tr'>
                <div className='th'>Ранее звонил: </div>
                <div className='td'>
                    {prevCall && <div>
                        <span>{ formatRelativeDateTime(prevCall.appearedAt) } </span>
                        (<span>{ formatShortDateTime(prevCall.appearedAt) }, </span>
                        {prevCall.isMissed
                            ? <span>ПРОПУЩЕН</span>
                            : <span>{ prevCall.phys?.name }</span>
                        })
                    </div>}
                </div>
            </div>
        </div>
    );
}
