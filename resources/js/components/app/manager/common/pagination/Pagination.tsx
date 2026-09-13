import {TPaginationLinks} from "@/types/types";

export type TProps = {
    links: TPaginationLinks[];
}

export default function ({ links } : TProps) {
    return (
        <>
            {links.length && (
                <ul>
                    {links.map((link, index) => (
                        link.url && <a key={index} href={link.url}>{link.label}</a>
                    ))}
                </ul>
            )}
        </>
    )
}
