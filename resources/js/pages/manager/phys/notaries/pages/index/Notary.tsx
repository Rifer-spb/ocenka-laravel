import { TNotary } from './types';

type TProps = {
    notary: TNotary
}

export default function ({ notary } : TProps) {
    return (
        <div className="tr tr-default">
            <div className="td name">{notary.name}</div>
            <div className="td address">{notary.address}</div>
            <div className="td phones">
                {notary.phones.map((phone, index) => <div key={index}>{phone.phone}</div>)}
            </div>
            <div className="td emails">
                {notary.emails.map((email, index) => <div key={index}>{email.email}</div>)}
            </div>
            <div className="td comment">{notary.comment}</div>
            <div className="td actions"></div>
        </div>
    )
}
