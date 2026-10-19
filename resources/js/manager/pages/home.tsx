import { useEcho } from '@laravel/echo-react';
import { usePage } from '@inertiajs/react';
import AppLayout from '@/manager/layouts/appManagerLayout';

export default function Home() {
    const { auth } = usePage<{ auth: { user: { id: number } | null } }>().props;

    if (auth.user) {
        useEcho(
            `user.${auth.user.id}`,
            '.UserEvent',
            (data: { message: string }) => {
                console.log('📨 ДОШЛО!', data);
            }
        );
    }

    return (
        <AppLayout>
            <h1>Добро пожаловать</h1>
        </AppLayout>
    );
}
