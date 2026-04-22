import AppLayout from '@/layouts/appManagerLayout';
import EmailComponent from "./EmailComponent";
import {usePage} from "@inertiajs/react";
import { SharedData } from "@/types";
import './index.css';
import NameComponent from "./NameComponent";
import {Profile, Phones} from "./account.types";
import PhonesComponent from "./PhonesComponent";

interface Props {
    profile: Profile,
    phones: Phones[]
}

export default function Home({ profile, phones }: Props) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    return (
        <AppLayout>
            <div className="account">
                <h1>Аккаунт</h1>
                <EmailComponent user={user}/>
                <NameComponent profile={profile}/>
                <PhonesComponent phones={phones} />
            </div>
        </AppLayout>
    );
}
