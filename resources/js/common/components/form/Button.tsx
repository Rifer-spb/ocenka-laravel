import * as React from "react";
import {cn} from "@common/utils/utils";

type TBaseProps = {
    className?: string;
    children: React.ReactNode;
    disabled?: boolean;
};

type TButtonProps =
    | (TBaseProps & { type: 'button'; onClick?: React.MouseEventHandler<HTMLButtonElement> })
    | (TBaseProps & { type: 'submit' | 'reset'; onClick?: never });

export default function Button(props: TButtonProps) {
    const { type, className = 'btn-primary', children, ...rest } = props;

    return (
        <button type={type} className={cn('btn', className)} {...rest}>
            {children}
        </button>
    );
}
