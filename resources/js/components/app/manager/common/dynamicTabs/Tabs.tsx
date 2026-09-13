import './Tabs.css';
import { TTabItem } from "./types";
import Tab from './Tab';
import React, {useEffect, useState} from "react";

type TProps = {
    items: TTabItem[];
    children: ((args: any) => React.ReactNode);
}

export default function ({ items, children } : TProps) {
    const [currentTab, setCurrentType] = useState<TTabItem | undefined>();

    const handleSelectTab = (e: any, tab: TTabItem ) => {
        e.preventDefault();
        setCurrentType(tab);
    };

    useEffect(() => {
        setCurrentType(items[0]);
    }, [items]);

    return (
        <>
            {currentTab && (
                <div className={'tabs'}>
                    <ul className={'staticTabs-items'}>
                        {items.map((item, index) =>
                            <Tab
                                key={index}
                                item={item}
                                currentItem={currentTab}
                                handleSelect={handleSelectTab}
                            />
                        )}
                        <div className='clear'></div>
                    </ul>
                    <div className={'tabs-content'}>
                        {children({currentTab})}
                    </div>
                </div>
            )}
        </>
    )
}
