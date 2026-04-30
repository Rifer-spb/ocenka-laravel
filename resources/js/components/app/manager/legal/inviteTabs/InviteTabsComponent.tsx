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
        getRequest(route('legals/invites/tabs', false))
            .then(response => {
                if (response.data?.length) {
                    const initialItems = response.data.map(item => ({ ...item, count: 0 }));
                    setItems(initialItems);

                    if (initialItems.length > 0) {
                        setCurrentTab(initialItems[0]);
                    }

                    return response;
                }
                throw new Error('Не удалось загрузить вкладки');
            })
            .then(() => getRequest(route('legals/invites/counts', false)))
            .then(response => {
                if (response.data) {
                    setItems(prevItems => prevItems.map(item => ({
                        ...item,
                        count: response.data[item.id] || 0
                    })));

                    return response;
                }
                throw new Error('Не удалось загрузить подсчеты вкладок');
            })
            .catch(error => console.error(error));
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
