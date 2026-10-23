export type * from './auth';
import type { TAuth } from './auth';

export type Flash = {
    success?: string | null;
    error?: string | null;
    warning?: string | null;
    info?: string | null;
};

export type SharedData = {
    name: string;
    auth: TAuth;
    sidebarOpen: boolean;
    flash: Flash;
    [key: string]: unknown;
};

export type TCall = {
    id: number;
    status: {
        isInProcess: boolean;
        isCompleted: boolean;
    };
    from: {
        phone: string;
        isMobile: boolean;
    },
    to: {
        phone: string;
    };
    legal: {
        name: string;
        fullName: string;
    };
    phys: {
        name: string;
    };
    appearedAt: string;
    prevCall: {
        appearedAt: string;
        phys: {
            name: string;
        };
    };
    countPrevCalls: number;
};
