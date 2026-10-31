import { TCall } from "../types";
import CallTo from "./CallTo";
import CallFrom from "./CallFrom";
import PrevCallInfo from "./PrevCallInfo";
import CallTalkPerson from "./CallTalkPerson";
import CallComments from "./CallComments";

export default function ({ call } : { call: TCall }) {
    return (
        <div className='current-call'>
            <CallTo call={call} />
            <CallFrom call={call} />
            {call.prevCall && <PrevCallInfo prevCall={call.prevCall}/>}
            {call.phys && <CallTalkPerson phys={call.phys} />}
            {call.prevCallsComments.length > 0 && <CallComments calls={call.prevCallsComments} />}
        </div>
    );
}
