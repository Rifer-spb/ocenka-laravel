import {cn} from "@common/utils/utils";
import React, {CSSProperties} from "react";

type TProps = {
    label?: string;
    className?: string;
    maxWidth?: CSSProperties['maxWidth'];
    children: React.ReactNode;
};

export default function ({ label, className, maxWidth, children } : TProps) {
    return (
        <section className={cn('block-section', className)} style={{ maxWidth }}>
            {label && <h2>Шаблоны комментариев</h2>}
            { children }
        </section>
    );
}
