import { TCallPhys } from "../types";

export default function CallTalkPerson({ phys } : { phys: TCallPhys }) {
    return (
        <div className='table call-talk-person'>
            <div className='tr'>
                <div className='th'>Разговаривает:</div>
                <div className='td'>{ phys.name }</div>
            </div>
        </div>
    );
}
