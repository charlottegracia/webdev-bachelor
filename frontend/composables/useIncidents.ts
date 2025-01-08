import { ref } from 'vue';
import axios from 'axios';
import { useRuntimeConfig } from '#app';
import type { Incident } from '.././types.ts';

export function useIncidents() {
  const incidents = ref<Incident[]>([]);

  const fetchIncidents = async () => {
    try {
      const config = useRuntimeConfig();
      const { data } = await axios.get(`${config.public.apiBase}/incidents`);

      // sort incidents by `created_at` to show newest incidents first
      incidents.value = data.sort((a: Incident, b: Incident) =>
        new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
      );
    } catch (error) {
      console.error('Error fetching incidents:', error);
    }
  };

  const resolveIncident = async (incidentId: number, resolvedAt: string) => {
    try {
      const config = useRuntimeConfig();
      const response = await axios.put(
        `${config.public.apiBase}/incidents/${incidentId}`,
        { resolved_at: resolvedAt },
        { headers: { 'Content-Type': 'application/json' } }
      );

      if (response.status !== 200) {
        throw new Error('Failed to mark incident as resolved');
      }
    } catch (error) {
      console.error('Error resolving incident:', error);
      throw error;
    }
  };

  const postIncident = async (data: Incident) => {
    try {
      const config = useRuntimeConfig();
      const response = await axios.post(`${config.public.apiBase}/incidents`, data)

      if (response.status >= 200 && response.status <= 299) {
        return response.data;
      } else {
        throw new Error('Failed to post incident');
      }
    } catch (error) {
      console.error('Error posting incident:', error);
      throw new Error('Failed to post incident');
    }
  };

  const deleteIncident = async (incidentId: number) => {
    try {
      const config = useRuntimeConfig();
      const response = await axios.delete(`${config.public.apiBase}/incidents/${incidentId}`, {
        headers: { 'Content-Type': 'application/json' },
      });

      if (response.status !== 200) {
        throw new Error('Failed to delete incident');
      }
    } catch (error) {
      console.error('Error deleting incident:', error);
      throw error;
    }
  };

  return {
    incidents,
    fetchIncidents,
    resolveIncident,
    deleteIncident,
    postIncident
  };
}
