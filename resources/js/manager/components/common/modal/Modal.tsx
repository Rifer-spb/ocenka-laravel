import './Modal.css';
import React, { useEffect, useState } from "react";

type TProps = {
    title: string;
    widthPercent?: number;
    isShow: boolean;
    onChange: Function;
    children: React.ReactNode;
}

export default function Modal({ title, widthPercent = 33, isShow, onChange, children } : TProps) {
    const [visible, setVisible] = useState<boolean>(false);
    const [render, setRender] = useState<boolean>(false);

    useEffect(() => {
        if (!isShow) {
            setVisible(false);
            setTimeout(() => setRender(false), 400);
            return;
        }

        setRender(true);
        const timer = setTimeout(() => setVisible(true), 50);
        return () => clearTimeout(timer);
    }, [isShow]);

    return render && (
        <div className={`app-modal-wrapper ${visible ? 'show' : ''}`}>
            <div className='app-modal' style={widthPercent ? {width: `${widthPercent}%`} : undefined}>
                <div className="app-modal-header">
                    <h5 className="app-modal-title">{title}</h5>
                    <button type="button" className='app-modal-close' onClick={() => onChange(false)}>
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div className="app-modal-body">{ children }</div>
            </div>
        </div>
    )
}
