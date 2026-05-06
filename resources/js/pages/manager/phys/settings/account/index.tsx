import AppLayout from '@/layouts/appManagerLayout';
import EmailComponent from "./EmailComponent";
import {usePage} from "@inertiajs/react";
import { SharedData } from "@/types";
import './index.css';
import NameComponent from "./NameComponent";
import {IProfile, IPhones} from "./account.types";
import PhonesComponent from "./PhonesComponent";
import HolidayComponent from "./HolidayComponent";
import PasswordComponent from "./PasswordComponent";

interface IProps {
    profile: IProfile;
    phones: IPhones[];
}

export default function Home({ profile, phones }: IProps) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    return (
        <AppLayout>
            <div className="account">
                <h1>Аккаунт</h1>
                <EmailComponent user={user}/>
                <NameComponent profile={profile}/>
                <PhonesComponent phones={phones} />
                <HolidayComponent holiday_from={profile.holiday_from} holiday_to={profile.holiday_to} />
                <PasswordComponent />
            </div>
        </AppLayout>
    );
}
