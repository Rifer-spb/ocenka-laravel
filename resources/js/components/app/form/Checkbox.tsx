type TProps = {
    label?: string;
    name: string;
    checked?: boolean
}

export default ({ label, name, checked } : TProps) => (
    <div className='form-group'>
        <input
            id={name}
            name={name}
            type="checkbox"
            defaultValue={checked}
        />
        {label && <label htmlFor={name}>{label}</label>}
    </div>
);
