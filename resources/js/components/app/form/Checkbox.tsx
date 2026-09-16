import {useQueryParams} from "@/hooks/useQueryParams";

type TProps = {
    label?: string;
    name: string;
}

export default ({ label, name } : TProps) => {
    const queryParams = useQueryParams();
    const selected = queryParams[name];
    const isChecked = selected === '1';

    return (
        <div className='form-group form-group-checkbox'>
            <input
                key={isChecked ? 'on' : 'off'}
                id={name}
                name={name}
                type="checkbox"
                value={1}
                defaultChecked={isChecked}
            />
            {label && <label htmlFor={name}>{label}</label>}
        </div>
    );
}
