import AppLayout from "@/layouts/appManagerLayout";
import EmailComponent from './EmailComponent';
import {usePage} from "@inertiajs/react";
import {SharedData} from "@/types";
import './index.css';
import { TType, TCompany } from "./types";
import CompanyComponent from "./CompanyComponent";
import PasswordComponent from "./PasswordComponent";

type TProps = {
    types: TType[];
    company: TCompany;
}

export default function ({ types, company } : TProps) {
    const { auth } = usePage<SharedData>().props;
    const user = auth.user;

    return (
        <AppLayout>
            <div className="account">
                <h1>Аккаунт</h1>
                <EmailComponent user={user}/>
                <CompanyComponent types={types} company={company} />
                <PasswordComponent />
            </div>
        </AppLayout>
    );
}
