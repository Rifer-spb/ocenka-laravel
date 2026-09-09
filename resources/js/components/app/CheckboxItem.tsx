type TProps = {
    className?: string;
    showLabel?: boolean;
    labelName?: string;
    checked: boolean;
    handler: () => void;
}

export default ({
    className = '',
    showLabel = false,
    labelName = '',
    checked,
    handler
} : TProps) => (
    <div className={`checkbox-item ${className}`}>
        {showLabel && labelName !== '' && <label >{labelName}</label>}
        <input
            type="checkbox"
            checked={checked}
            onChange={handler}
        />
    </div>
);
