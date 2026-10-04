// components/ui/radio.tsx
import * as React from "react"
import { cn } from "@/utils/utils"

const Radio = React.forwardRef<
    HTMLInputElement,
    React.InputHTMLAttributes<HTMLInputElement>
>(({ className, ...props }, ref) => {
    return (
        <input
            type="radio"
            ref={ref}
            className={cn(
                "peer size-4 shrink-0 rounded-full border border-input shadow-xs transition-all",
                "focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2",
                "disabled:cursor-not-allowed disabled:opacity-50",
                "checked:bg-primary checked:border-primary checked:ring-2 checked:ring-primary/20",
                className
            )}
            {...props}
        />
    )
})
Radio.displayName = "Radio"

export { Radio }
