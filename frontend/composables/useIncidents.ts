import { ref } from 'vue';
import axios from 'axios';
import { useRuntimeConfig } from '#app';

type Carrier = {
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

export type Incident = {
  incident_id: number;
  title: string;
  message: string;
  critical: number;
  country: string;
  type: string;
  status: string;
  expected_resolved_at?: string | null; 
  resolved_at?: string | null;      
  created_at?: string | null;
  updated_at: string;
  carriers: Carrier[];
};

export function useIncidents() {
  const incidents = ref<Incident[]>([]);

  const fetchIncidents = async () => {
    try {
      const config = useRuntimeConfig();
      const { data } = await axios.get(`${config.public.apiBase}/incidents`);
      incidents.value = data;
      console.log('Incidents:', incidents.value);
    } catch (error) {
      console.error('Error fetching incidents:', error);
    }
  };

  return {
    incidents,
    fetchIncidents,
  };
}
