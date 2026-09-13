import './StaticTabs.css';
import { TStaticTabLink } from "./types";
import StaticTab from './StaticTab';
import React from "react";
import {usePage} from "@inertiajs/react";

type TProps = {
    items: TStaticTabLink[];
    children: React.ReactNode;
}

export default function ({ items, children } : TProps) {
    const { url } = usePage();
    const pathname = url.split('?')[0];

    return (
        <div className={'tabs'}>
            <ul className={'staticTabs-items'}>
                {items.map((item, index) =>
                    <StaticTab key={index} item={item} url={pathname}/>
                )}
                <div className='clear'></div>
            </ul>
            <div className={'tabs-content'}>{children}</div>
        </div>
    )
}
