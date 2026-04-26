import React, { useState } from "react";
import './InviteTabsComponent.css';

interface Props {
    children: (args: any) => React.ReactNode;
}

export default function ({ children } : Props) {
    const [items] = useState([
        { id: 'inbox', name: 'Входящие', count: 0 },
        { id: 'outbox', name: 'Исходящие', count: 0 },
        { id: 'active', name: 'Действующие', count: 0 },
        { id: 'fired', name: 'Уволенные', count: 0 },
    ]);

    const [activeTab, setActiveTab] = useState('inbox');

    return (
        <>
            <div className="invite-tabs">
                <ul>
                    {items.map((item, index) => (
                        <li key={index} className={`${item.id} ${activeTab === item.id ? 'current' : ''}`}>
                            <a
                                href="#"
                                onClick={(e) => {
                                    e.preventDefault();
                                    setActiveTab(item.id);
                                }}
                            >
                                {item.name} ({item.count})
                            </a>
                        </li>
                    ))}
                </ul>
                <div className="invite-tabs-content">
                    {children({activeTab})}
                </div>
            </div>
        </>
    );
}
