import { User } from "@/types";

interface Props {
    user: User;
}

export default function ({ user } : Props) {
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
