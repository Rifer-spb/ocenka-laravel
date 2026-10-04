import * as React from "react";
import {cn} from "@common/utils/utils";

type TProps = {
    type: 'submit' | 'button' | 'reset';
    className?: string;
    children: React.ReactNode;
}

export default function Button({ type, className, children}: TProps) {
  return (<button type={type} className={cn('btn', className)}>{children}</button>)
}
