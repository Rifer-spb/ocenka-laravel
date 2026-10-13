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

export type TEmployeesAccess = {
    id: number;
    name: string;
    value: boolean;
}
