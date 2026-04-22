export type User = {
    id: number;
    email: string;
    email_verified_at: string | null;
    role: string;
    [key: string]: unknown;
};

export type Auth = {
    user: User;
    isAuthenticated: Boolean;
};
