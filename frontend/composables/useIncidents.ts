import axios from 'axios';
import { useRuntimeConfig } from '#app';
import { useI18n } from 'vue-i18n';
import type { Incident } from '.././types.ts';

export function useIncidents() {
  const incidents = ref<Incident[]>([]);
  const config = useRuntimeConfig();
  const { locale } = useI18n();

  const fetchIncidents = async () => {
    try {
      const { data } = await axios.get(`${config.public.apiBase}/incidents`);

      if (locale.value === 'en') {
        const translatedIncidents = await Promise.all(
          data.map(async (incident: Incident) => {
            const translatedTitle = await translateText(incident.title, 'en');
            const translatedDescription = await translateText(incident.message, 'en');
            return {
              ...incident,
              title: translatedTitle,
              message: translatedDescription,
            };
          })
        );

        incidents.value = translatedIncidents.sort((a: Incident, b: Incident) =>
          new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        );
      } else {
        incidents.value = data.sort((a: Incident, b: Incident) =>
          new Date(b.created_at).getTime() - new Date(a.created_at).getTime()
        );
      }
    } catch (error) {
      console.error('Error fetching incidents:', error);
    }
  };

  const translateText = async (text: string, targetLang: string): Promise<string> => {
    try {
      const response = await axios.get(`https://translate.googleapis.com/translate_a/single`, {
        params: {
          client: 'gtx',
          sl: 'da', // Source language (auto-detect)
          tl: targetLang, // Target language
          dt: 't', // Translation text
          q: text, // Text to translate
        },
      });

      // Extract the translated text from the response
      return response.data[0][0][0];
    } catch (error) {
      console.error('Error translating text:', error);
      return text; // Fallback to original text if translation fails
    }
  };

  const postIncident = async (data: Incident) => {
    try {
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

  const resolveIncident = async (incidentId: number, resolvedAt: string) => {
    try {
      const response = await axios.put(
        `${config.public.apiBase}/incidents/${incidentId}`,
        { resolved_at: resolvedAt }
      );

      if (response.status !== 200) {
        throw new Error('Failed to mark incident as resolved');
      }
    } catch (error) {
      console.error('Error resolving incident:', error);
      throw error;
    }
  };

  const deleteIncident = async (incidentId: number) => {
    try {
      const response = await axios.delete(`${config.public.apiBase}/incidents/${incidentId}`);

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
