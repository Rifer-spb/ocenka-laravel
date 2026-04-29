import React, { useState } from "react";
import './InviteTabsComponent.css';
import { InviteTab } from "./types";

interface Props {
    children: ((args: any) => React.ReactNode) | React.ReactNode;
    handleEvent: Function
}

export default function ({ children, handleEvent } : Props) {
    const [items] = useState<InviteTab[]>([
        { id: 'inbox', name: 'Входящие', count: 0 },
        { id: 'outbox', name: 'Исходящие', count: 0 },
        { id: 'active', name: 'Действующие', count: 0 },
        { id: 'fired', name: 'Уволенные', count: 0 },
    ]);

    const [currentTab, setCurrentTab] = useState(items[0]);

    return (
        <>
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
                        ? children({currentTab})
                        : children}
                </div>
            </div>
        </>
    );
}
