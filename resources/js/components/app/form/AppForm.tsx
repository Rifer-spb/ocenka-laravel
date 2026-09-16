import React from "react";
import {router, usePage} from "@inertiajs/react";

type TProps = {
    method: 'get' | 'post' | 'put' | 'patch' | 'delete';
    action: string;
    children: (args: any) => React.ReactNode;
    onChange?: boolean;
    onSuccess?: (page: any) => void;
    onError?: (errors: Record<string, string>) => void;
    resetOnSuccess?: boolean;
}

export default ({ method, action, children, onChange, onSuccess, onError, resetOnSuccess = false } : TProps)  => {
    const { errors } = usePage().props as { errors: Record<string, string> };

    const handleSubmit = (e: any) => {
        e.preventDefault();
        const form = e.currentTarget;
        const formData = new FormData(form);
        const data = Object.fromEntries(formData.entries());
        e.currentTarget.querySelectorAll('input[type="checkbox"][name]').forEach((el: any) => {
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
        >
            {children({ errors })}
        </form>
    );
}
