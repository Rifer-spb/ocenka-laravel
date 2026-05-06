export interface ILegal {
    name: string
}

export interface IStatus {
    id: number,
    name: string
}

export interface IInviteItem {
    id: number,
    legal: ILegal,
    status: IStatus,
    created_at: string,
    rejected_at: string | null,
    fired_at: string | null
}
