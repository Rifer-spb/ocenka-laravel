import AppLayout from "@/layouts/appManagerLayout";
import EmailComponent from './EmailComponent';
import {usePage} from "@inertiajs/react";
import {SharedData} from "@/types";
import './index.css';

export default function () {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    return (
        <AppLayout>
            <div className="account">
                <h1>Аккаунт</h1>
                <EmailComponent user={user}/>
            </div>
        </AppLayout>
    );
}
