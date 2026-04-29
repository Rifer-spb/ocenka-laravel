export interface Legal {
    name: string
}

export interface Status {
    id: number,
    name: string
}

export interface InviteItem {
    id: number,
    legal: Legal,
    status: Status,
    created_at: string,
    rejected_at: string | null,
    fired_at: string | null
}
