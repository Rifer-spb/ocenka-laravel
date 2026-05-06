export type * from './Auth';
export type * from './navigation';
export type * from './ui';

import type { TAuth } from './Auth';

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
