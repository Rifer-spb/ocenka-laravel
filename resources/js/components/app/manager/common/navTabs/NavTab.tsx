import { TNavTabLink } from "./types";
import { Link } from '@inertiajs/react';

type TProps = {
    url: string;
    item: TNavTabLink;
}

export default function ({ url, item } : TProps) {
    return (
        <>
            <li className={url === item.url ? 'active' : ''}>
                <Link href={item.url}>{item.name}</Link>
            </li>
        </>
    )
}
