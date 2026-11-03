import { TPrevCallsComments } from "../types";
import { formatShortDateTime } from "@common/helpers/dateHelper";
import { useState } from "react";

const LIMIT = 10;

export default function CallComments({ calls } : { calls: TPrevCallsComments[] }) {
    const [page, setPage] = useState<number>(1);
    const items = calls.slice(0, LIMIT * page);
    const hasMore = calls.length > items.length;

    return (
        <div className='call-comments'>
            <h5>Комментарии:</h5>
            <div className='list'>
                {items.map(call => <div key={call.id}>
                    { formatShortDateTime(call.appearedAt) } { call.phys ? call.phys.name : 'Не определен' }: { call.comment }
                </div>)}
            </div>
            {hasMore && <button type='button' className='call-comments-more' onClick={() => setPage(p => p + 1)}>
                [Еще комментарии]
            </button>}
        </div>
    );
}
