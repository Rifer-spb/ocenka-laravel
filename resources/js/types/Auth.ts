export type TUser = {
    id: number;
    email: string;
    email_verified_at: string | null;
    role: string;
    [key: string]: unknown;
};

export type TAuth = {
    user: TUser;
    isAuthenticated: Boolean;
};
