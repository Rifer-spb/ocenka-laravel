import React, { useState } from "react";
import './InviteTabs.css';
import { IInviteTab } from "./types";
import { useEffect } from 'react';

type IProps = {
    children: ((args: any) => React.ReactNode) | React.ReactNode;
    tabs: IInviteTab[];
    counts: any;
    handleEvent: Function;
}

export default function ({ children, tabs, counts, handleEvent } : IProps) {
    const [items, setItems] = useState<IInviteTab[]>([]);
    const [currentTab, setCurrentTab] = useState<IInviteTab | undefined>();

    useEffect(() => {
        const params = new URLSearchParams(window.location.search);
        const typeFromUrl = params.get('type');

        const mapped = tabs.map(item => ({
            ...item,
            count: counts[item.id] || 0
        }));

        setItems(mapped);

        const activeTab = mapped.find(tab => tab.id === typeFromUrl) || mapped[0];
        setCurrentTab(activeTab);
    }, [counts, tabs]);

    return (
        <>
            {currentTab && (
                <div className="invite-tabs">
                    <ul>
                        {items.map((item, index) => (
                            <li key={index} className={`${item.id} ${currentTab.id === item.id ? 'current' : ''}`}>
                                <a
                                    href="#"
                                    onClick={(e) => {
                                        e.preventDefault();
                                        setCurrentTab(item);
                                        handleEvent(item);
                                    }}
                                >
                                    {item.name} ({item.count})
                                </a>
                            </li>
                        ))}
                    </ul>
                    <div className="invite-tabs-content">
                        {typeof children === 'function'
                            ? children({ currentTab })
                            : children}
                    </div>
                </div>
            )}
        </>
    );
}
