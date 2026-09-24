import './NavTabs.css';
import { TNavTabLink } from "./types";
import NavTab from './NavTab';
import React from "react";
import {usePage} from "@inertiajs/react";

type TProps = {
    items: TNavTabLink[];
    children: React.ReactNode;
}

export default function ({ items, children } : TProps) {
    const { url } = usePage();
    const pathname = url.split('?')[0];

    return (
        <div className='tabs'>
            <ul className='staticTabs-items'>
                {items.map((item, index) =>
                    <NavTab key={index} item={item} url={pathname}/>
                )}
                <div className='clear'></div>
            </ul>
            <div className='tabs-content'>{children}</div>
        </div>
    )
}
