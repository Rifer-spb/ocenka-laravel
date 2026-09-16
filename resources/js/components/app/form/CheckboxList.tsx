import { Label } from "@/components/ui/label";
import Checkbox from "./Checkbox";
import InputError from "../../../../jsOld/components/input-error";

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
            <InputError message={error}/>
        </div>
    );
}
