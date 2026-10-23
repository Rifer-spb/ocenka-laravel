import { TCall } from "@manager/types";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faSms } from '@fortawesome/free-solid-svg-icons';

export default function ({ call } : { call: TCall }) {
    return (
        <div className='current-call'>
            <h2>Звонок на {call.legal.name}: {call.to.phone}</h2>
            <h2>
                Звонит {call.from.phone}
                {call.countPrevCalls && <span> [{call.countPrevCalls}]</span>}
                {call.from.isMobile && <span>
                    <a href="#" title="Отправка sms">
                        <FontAwesomeIcon icon={faSms} />
                    </a>
                </span>}
            </h2>
        </div>
    );
}
