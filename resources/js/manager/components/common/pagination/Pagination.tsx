import {TPaginationMeta} from "@common/types/types";
import './Pagination.css';

type TProps = {
    meta: TPaginationMeta;
}

export default function ({ meta } : TProps) {
    return meta.links.length <= 3 ? null : (
        <ul className='pagination'>
            {meta.links.map((link, index) =>
                link.url && (
                    <li key={index} className={meta.current_page == link.page ? 'active' : ''}>
                        <a href={link.url}>{link.label}</a>
                    </li>
                )
            )}
        </ul>
    )
}
