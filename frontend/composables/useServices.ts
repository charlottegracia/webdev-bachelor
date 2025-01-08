import axios from 'axios';
import { useRuntimeConfig } from '#app';
import type { Service } from '~/types.ts';

export function useServices() {
  const services = ref<Service[]>([]);
  const config = useRuntimeConfig();

  const fetchServices = async () => {
    try {
      const { data } = await axios.get(`${config.public.apiBase}/services`);
      
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
