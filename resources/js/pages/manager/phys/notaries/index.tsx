import AppLayout from '@/layouts/appManagerLayout';
import { TPaginated } from '@/types/types';

type TNotary = {
    id: number;
    region: { name: string };
    name: string;
    address: string;
    comment?: string;
    phones: Array<{phone: string}>;
    emails: Array<{email: string}>;
}

type TProps = {
    notaries: TPaginated<TNotary>;
};

export default function ({ notaries } : TProps) {
    console.log(notaries.data);

    return (
        <AppLayout>
            <div>
                <h1>Нотариусы</h1>

            </div>
        </AppLayout>
    );
}
