import React, {useEffect, useState} from "react";
import {router, usePage} from "@inertiajs/react";
import { useQueryParams } from "@common/hooks/hooks";
import { collectFormData } from "@common/utils/form";

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
    const query = useQueryParams();
    const { errors: serverErrors } = usePage().props as { errors: Record<string, string> };
    const [dismissed, setDismissed] = useState(false);
    const errors = dismissed ? {} : serverErrors;

    const fromQuery = (key: string): string | undefined => {
        const v = query[key];
        return Array.isArray(v) ? v[0] : v;
    };

    const handleSubmit = (e: any) => {
        if (e.type === 'submit') {
            e.preventDefault();
        }

        const form = e.currentTarget;
        const data = collectFormData(form);

        router[method](action, data, {
            preserveState: true,
            preserveScroll: true,
            replace: true,
            onSuccess: (page) => {
                if (resetOnSuccess) {
                    form.reset();
                    setDismissed(true);
                }
                onSuccess?.(page);
            },
            onError: (errors) => {
                setDismissed(false);
                onError?.(errors);
            },
        });
    };

    useEffect(() => {
        setDismissed(true);
    }, []);

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
