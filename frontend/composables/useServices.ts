import { ref } from 'vue';
import axios from 'axios';
import { useRuntimeConfig } from '#app';
import type { Service } from '~/types.ts';

export function useServices() {
  const services = ref<Service[]>([]);

  // Fetch carriers data
  const fetchServices = async () => {
    try {
      const config = useRuntimeConfig();
      const { data } = await axios.get(`${config.public.apiBase}/services`);
      
      // Sort carriers by `title` alphabetically
      services.value = data.sort((a: Service, b: Service) => a.title.localeCompare(b.title));
    } catch (error) {
        console.error('Error fetching carriers:', error);
      }
  };

  return {
    services,
    fetchServices,
  };
}
