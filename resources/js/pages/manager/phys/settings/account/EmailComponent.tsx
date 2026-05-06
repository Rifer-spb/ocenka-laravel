import { TUser } from "@/types";

interface IProps {
    user: TUser;
}

export default function ({ user } : IProps) {
    return (
        <section style={{ maxWidth: '400px' }}>
            <h2>E-mail:</h2>
            <div>{ user.email }</div>
            {!user.email_verified_at && (
                <div
                    className="alert alert-danger"
                    role="alert"
                    style={{ marginBottom: 0, marginTop: '20px' }}
                >E-mail адрес не подтвержден!</div>
            )}
        </section>
    );
}
