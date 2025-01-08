import countriesData from '~/public/countries.js';
import type { Country } from '~/types.ts';

export function useCountries() {
  const countries = ref<Country[]>(countriesData.COUNTRIES);
  return { countries };
}
