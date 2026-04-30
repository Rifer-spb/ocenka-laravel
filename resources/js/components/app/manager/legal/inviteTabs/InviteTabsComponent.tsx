import React, { useState } from "react";
import './InviteTabsComponent.css';
import { InviteTab } from "./types";
import { getRequest } from '@/services/api';
import { useEffect } from 'react';
import { useManagerRoute } from '@/hooks/useManagerRoute';

interface Props {
    children: ((args: any) => React.ReactNode) | React.ReactNode;
    handleEvent: Function
}

export default function ({ children, handleEvent } : Props) {
    const route = useManagerRoute();
    const [items, setItems] = useState<InviteTab[]>([]);
    const [currentTab, setCurrentTab] = useState<InviteTab | undefined>();

    useEffect(() => {
        Promise.all([
            getRequest(route('legals/invites/tabs', false)),
            getRequest(route('legals/invites/counts', false))
        ])
            .then(([tabsRes, countsRes]) => {
                const tabs = tabsRes.data ?? [];
                const counts = countsRes.data ?? {};

                const mapped = tabs.map(item => ({
                    ...item,
                    count: counts[item.id] || 0
                }));

                setItems(mapped);
                setCurrentTab(mapped[0]);
            })
            .catch(console.error);
    },[]);

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
