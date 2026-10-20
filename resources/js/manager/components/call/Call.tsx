import './Call.css';
import { useEffect } from "react";

export default function ({ calls }) {
    useEffect(() => {
        console.log(calls);
    }, [calls]);

    return (
        <div className='call-overlay'>
            <div className='call'>
                <h1>Входящий звонок</h1>
            </div>
        </div>
    );
}
