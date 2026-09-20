import React from "react";
import {router, usePage} from "@inertiajs/react";
import { useQueryParams } from "@/hooks/hooks";

type TProps = {
    method: 'get' | 'post' | 'put' | 'patch' | 'delete';
    action: string;
    children: (args: any) => React.ReactNode;
    onChange?: boolean;
    onSuccess?: (page: any) => void;
    onError?: (errors: Record<string, string>) => void;
    resetOnSuccess?: boolean;
    style?: object;
}

export default function InertiaForm({ method, action, children, onChange, onSuccess, onError, resetOnSuccess = false, style } : TProps)  {
    const { errors } = usePage().props as { errors: Record<string, string> };
    const query = useQueryParams();

    const fromQuery = (key: string): string | undefined => {
        const v = query[key];
        return Array.isArray(v) ? v[0] : v;
    };

    const handleSubmit = (e: any) => {
        if (e.type === 'submit') {
            e.preventDefault();
        }

        const form = e.currentTarget;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        form.querySelectorAll('input[type="checkbox"][name]:not([name$="[]"])').forEach((el: any) => {
            data[el.name] = el.checked ? '1' : '0';
        });

        router[method](action, data, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onSuccess: (page) => {
                if (resetOnSuccess) {
                    form.reset();
                }
                onSuccess?.(page);
            },
            onError,
        });
    };

    return (
        <form
            method={method}
            action={action}
            {...(onChange ? { onChange: handleSubmit } : { onSubmit: handleSubmit })}
            style={style}
        >
            {children({ errors, fromQuery })}
        </form>
    );
}
