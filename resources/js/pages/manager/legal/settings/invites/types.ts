export type ILegal = {
    name: string;
}

export type IStatus = {
    id: number;
    name: string;
}

export type IReportAccess = {
    id: number;
    name: string;
    do: boolean;
    write: boolean;
}

export type IEmployee = {
    name: string;
    access: {
        ride: boolean;
        report: IReportAccess[];
    };
    isManager: boolean;
    workRate: number | null;
}

export type IInviteItem = {
    id: number;
    legal: ILegal;
    status: IStatus;
    created_at: string;
    completed_at: string | null;
    employee: IEmployee;
}
