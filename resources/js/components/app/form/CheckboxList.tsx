import { Label } from "@/components/ui/label";
import InputError from "@/components/input-error";
import Checkbox from "./Checkbox";

type TOption = {
    label: string;
    value: string;
}

type TProps = {
    name: string;
    error?: string;
    label?: string;
    options: TOption[];
}

export default ({ name, error, label, options } : TProps) => {
    return (
        <div className="form-group">
            <Label htmlFor={name}>{label}</Label>
            {options.map((item, index) =>
                <Checkbox
                    name={name}
                    label={item.label}
                />
            )}
            <InputError className="error" message={error}/>
        </div>
    );
}
