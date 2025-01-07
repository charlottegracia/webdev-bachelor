export type Carrier = {
    carrier_id: number;
    slug: string;
    title: string;
    type: string;
    description: string;
    status: string;
    peak_up_charge: string;
    created_at: string | null;
    updated_at: string;
};

export type Country = {
    name: string;
    code: string;
};

export type Service = {
    service_id: number;
    title: string;
    description: string;
    status: string;
    created_at: string;
    updated_at: string;
};

export type Incident = {
    incident_id: number;
    title: string;
    message: string;
    country: string; // Country is a string of codes ("AF,AG")
    status: string;
    resolved_at?: string | null;
    expected_resolved_at?: string | null;
    created_at: string;
    updated_at: string;
    critical: number;
    type: string;
    services: Service[]; 
    carriers: Carrier[];
};
