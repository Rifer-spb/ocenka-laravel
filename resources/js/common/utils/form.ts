export function collectFormData(form: HTMLFormElement): Record<string, any> {
    const data: Record<string, any> = {};

    for (const [key, value] of new FormData(form).entries()) {
        if (key.endsWith('[]')) {
            const k = key.slice(0, -2);
            (data[k] ??= []).push(value);
        } else {
            data[key] = value;
        }
    }

    form
        .querySelectorAll('input[type="checkbox"][name]:not([name$="[]"])')
        .forEach((el: any) => {
            data[el.name] = el.checked ? '1' : '0';
        });

    return data;
}
