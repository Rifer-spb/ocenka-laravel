export type TPaginationLink = {
    url: string | null;
    label: string;
    page: number | null;
    active: boolean;
}

export type TPaginationMeta = {
    current_page: number;
    first_page_url: string;
    from: number | null;
    last_page: number;
    last_page_url: string;
    links: TPaginationLink[];
    next_page_url: string | null;
    path: string;
    per_page: number;
    prev_page_url: string | null;
    to: number | null;
    total: number;
};

export type TPaginated<T> = TPaginationMeta & {
    data: T[];
};
