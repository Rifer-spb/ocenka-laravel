export type TCallPhys = {
    name: string;
};

export type TPrevCall = {
    appearedAt: string;
    phys?: TCallPhys;
    isMissed: boolean;
};

export type TPrevCallsComments = {
    id: number;
    appearedAt: string;
    comment: string;
    phys?: TCallPhys;
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
    phys?: TCallPhys;
    appearedAt: string;
    prevCall?: TPrevCall;
    countPrevCalls: number;
    prevCallsComments: TPrevCallsComments[];
};
