import axios from 'axios';
import { useRuntimeConfig } from '#app';
import type { Carrier } from '~/types.ts';

export function useCarriers() {
  const carriers = ref<Carrier[]>([]);
  const config = useRuntimeConfig();


  const fetchCarriers = async () => {
    try {
      const { data } = await axios.get(`${config.public.apiBase}/carriers`);
      
      carriers.value = data.sort((a: Carrier, b: Carrier) => a.title.localeCompare(b.title));
    } catch (error) {
        console.error('Error fetching carriers:', error);
      }
  };
  const postCarrier = async (data: Carrier) => {
    try {
      const response = await axios.post(`${config.public.apiBase}/carriers`, data)

      if (response.status >= 200 && response.status <= 299) {
        return response.data; 
      } else {
        throw new Error('Failed to post carrier');
      }
    } catch (error) {
      console.error('Error posting carrier:', error);
      throw new Error('Failed to post carrier');  
    }
  };

  return {
    carriers,
    fetchCarriers,
    postCarrier
  };
}
