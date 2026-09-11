type TProps = {
    className?: string;
    labelName?: string;
    checked: boolean;
    handler: () => void;
}

export default ({
    className = '',
    labelName = '',
    checked,
    handler
} : TProps) => (
    <div className={`checkbox-item ${className}`}>
        {labelName !== '' && <label >{labelName}</label>}
        <input
            type="checkbox"
            checked={checked}
            onChange={handler}
        />
    </div>
);
