import { Label } from "@/components/ui/label";
import InputError from "@/components/app/form/InputError";
import { useQueryParams } from "@/hooks/useQueryParams";

type TProps = {
    name: string;
    error?: string;
    label?: string;
    disabled?: boolean;
    options: Record<number, string>;
    showDefaultOption?: boolean;
    defaultOptionName?: string;
}

export default ({
    name,
    error,
    label,
    disabled = false,
    options,
    showDefaultOption = true,
    defaultOptionName
} : TProps) => {
    const queryParams = useQueryParams();
    const selected = queryParams[name];

    return (
        <div className="form-group">
            {label && <Label htmlFor={name}>{label}</Label>}
            <select
                name={name}
                className='form-control'
                disabled={disabled}
                defaultValue={selected || ''}
            >
                {showDefaultOption && <option value=''>
                    {defaultOptionName ? defaultOptionName : 'Выберите из списка' }
                </option>}

                {Object.entries(options).map(([id, label]) => (
                    <option key={id} value={id}>{label}</option>
                ))}
            </select>
            <InputError message={error}/>
        </div>
    );
}
