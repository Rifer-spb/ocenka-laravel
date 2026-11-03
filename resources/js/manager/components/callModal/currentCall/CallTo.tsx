import {TCall} from "../types";

export default function CallTo({ call } : { call: TCall }) {
    return (
        <div className='call-to'>
            <h2>Звонок на {call.legal.name}: {call.to.phone}</h2>
        </div>
    );
}
