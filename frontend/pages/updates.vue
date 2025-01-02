<template>
  <div class="flex flex-col gap-8 items-center max-w-screen-md mx-auto pt-40">
    <div class="flex items-center gap-4">
      <Icon src="Broadcast" size="6xl" color="text-homeblue-300" />
      <h1 class="fields text-[32px] md:text-[64px] text-homeblue-300">Liveopdateringer</h1>
    </div>
    <p class="md:max-w-[75%] font-semibold text-center">
      På denne side findes en liste med Homerunners liveopdateringer. De opdateres løbende, når de bliver løst.
    </p>

    <div class="self-start">
      <p class="text-lg mb-2">Filtrer efter kategori:</p>
      <div class="text-lg flex gap-4">
        <!-- Countries Button -->
        <button
          :class="['py-2 px-4 transition duration-200 rounded shadow-lg flex items-center font-medium gap-2', filters.countries ? 'bg-home-kiwi-200 border border-home-kiwi-300' : 'bg-home-kiwi border border-home-kiwi']"
          @click="toggleFilter('countries')">
          Lande
          <!-- Icon when 'countries' filter is active -->
          <Icon v-if="filters.countries" src="Check" size="lg" color="text-home-kiwi-300" />
        </button>

        <!-- Carriers Button -->
        <button
          :class="['py-2 px-4 transition duration-200 rounded shadow-lg flex items-center font-medium gap-2', filters.carriers ? 'bg-home-tangerine-200 border border-home-tangerine-300' : 'bg-home-tangerine border border-home-tangerine']"
          @click="toggleFilter('carriers')">
          Transportører
          <!-- Icon when 'carriers' filter is active -->
          <Icon v-if="filters.carriers" src="Check" size="lg" color="text-home-tangerine-300" />
        </button>

        <!-- Services Button -->
        <button
          :class="['py-2 px-4 transition duration-200 rounded shadow-lg flex items-center font-medium gap-2', filters.services ? 'bg-home-grape-200 border border-home-grape-300' : 'bg-home-grape border border-home-grape']"
          @click="toggleFilter('services')">
          IT-services
          <Icon v-if="filters.services" src="Check" size="lg" color="text-home-grape-300" />
        </button>
      </div>
      <div class="flex gap-2 items-center mt-4 text-lg">
        <input type="checkbox" v-model="filters.resolved" class="h-4 w-4" />
        <label @click="toggleFilter('resolved')">
          Filtrer løste hændelser fra
        </label>
      </div>
    </div>

    <!-- Display message when no incidents match the filters -->
    <div v-if="filteredIncidents.length === 0" class="text-center text-2xl fields mt-8 text-homeblue-300">
      Der er ingen liveopdateringer med de valgte filtre.
    </div>

    <!-- Display filtered incidents -->
    <div v-else v-for="incident in filteredIncidents" :key="incident.incident_id" class="w-full">
      <Incident :incident="incident" />
    </div>
  </div>
</template>


<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

// Define types for the incidents and filters
interface IncidentType {
  incident_id: number;
  title: string;
  message: string;
  country: { country_id: number; title: string }[]; // Country must be an array of objects
  status: string;
  resolved_at?: string | null;
  expected_resolved_at?: string | null;
  created_at?: string | null;
  updated_at: string;
  critical: number;
  type: string;
  services: { id: number; title: string }[];
  carriers: { carrier_id: number; title: string }[];
}

interface Filters {
  resolved: boolean;
  carriers: boolean;
  countries: boolean;
  services: boolean;
}

// Declare incidents and filters with the types
const incidents = ref<IncidentType[]>([]);
const filters = ref<Filters>({
  resolved: false,  // If the button is pressed, show only unresolved incidents
  carriers: false,  // Show incidents with carriers
  countries: false, // Show incidents with countries
  services: false,  // Show incidents with services
});

const config = useRuntimeConfig();

onMounted(async () => {
  try {
    const { data } = await axios.get(`${config.public.apiBase}/incidents`);
    incidents.value = data.map((incident: any) => ({
      ...incident,
      // Ensure country is an array of objects with country_id and title
      country: Array.isArray(incident.country)
        ? incident.country
        : [{ country_id: 1, title: incident.country }], // If country is a string, convert it to an object array

      // Ensure carriers is an array of objects with carrier_id and title
      carriers: Array.isArray(incident.carriers)
        ? incident.carriers
        : [{ carrier_id: 1, title: incident.carriers }], // Similar mapping for carriers

      // Ensure services is always an array, even if empty
      services: incident.services || [],

      critical: incident.critical || 0,  // Default to 0 if `critical` is undefined
      status: incident.status || '',     // Default to empty string if `status` is undefined
    }));
    incidents.value = incidents.value.sort(
      (a: IncidentType, b: IncidentType) => new Date(b.updated_at).getTime() - new Date(a.updated_at).getTime()
    );
    console.log('opdateringer:', incidents.value);
  } catch (error) {
    console.error('Fejl ved hentning af liveopdateringer:', error);
  }
});

// Function to toggle filter state
const toggleFilter = (filter: keyof Filters) => {
  filters.value[filter] = !filters.value[filter];
};

// Filtered incidents based on selected filters
const filteredIncidents = computed(() => {
  return incidents.value.filter((incident) => {
    // Filter by resolved status (if 'resolved' button is pressed)
    const resolvedFilter = filters.value.resolved
      ? !incident.resolved_at // Show only unresolved incidents
      : true; // Show all incidents (resolved or unresolved)

    // Filter by carriers (if 'carriers' button is pressed)
    const carrierFilter = filters.value.carriers
      ? incident.carriers.length > 0  // Show incidents with carriers
      : true; // Show all incidents regardless of carriers

    // Filter by countries (if 'countries' button is pressed)
    const countryFilter = filters.value.countries
      ? incident.country.length > 0 // Show incidents with countries
      : true; // Show all incidents regardless of countries

    // Filter by services (if 'services' button is pressed)
    const serviceFilter = filters.value.services
      ? incident.services.length > 0  // Show incidents with services
      : true; // Show all incidents regardless of services

    return resolvedFilter && carrierFilter && countryFilter && serviceFilter;
  });
});
</script>

<style scoped>
/* Add your custom styles here */
</style>