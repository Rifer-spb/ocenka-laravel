import { Label } from "@/components/ui/label";
import { Input } from "@/components/ui/input";
import InputError from "@/components/input-error";

type TProps = {
    name: string;
    type?: string;
    error?: string;
    label?: string;
    placeholder?: string;
    disabled?: boolean;
    value?: string
}

export default ({
    name,
    type = 'text',
    error,
    label,
    placeholder = '',
    disabled = false,
    value
} : TProps) => {
    return (
        <div className="form-group">
            <Label htmlFor={name}>{label}</Label>
            <Input
                id={name}
                name={name}
                type={type}
                required
                style={{backgroundColor: '#fff'}}
                placeholder={placeholder}
                disabled={disabled}
                defaultValue={value}
            />
            <InputError className="error" message={error}/>
        </div>
    );
}
