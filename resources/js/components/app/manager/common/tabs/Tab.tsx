import { TTabItem } from "./types";

type TProps = {
    item: TTabItem;
    currentItem: TTabItem;
    handleSelect: Function;
}

export default function ({ item, currentItem, handleSelect } : TProps) {
    return (
        <>
            <li className={currentItem.id == item.id ? 'active' : ''}>
                {item.url ? <a href={item.url}>{item.name}</a> :
                    <a href='#' onClick={(e) => handleSelect(e, item)}>
                        {item.name}
                    </a>
                }
            </li>
        </>
    )
}
