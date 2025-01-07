<template>
  <div class="flex flex-col gap-8 items-center max-w-screen-md mx-auto">
    <div class="flex items-center gap-8">
      <Icon src="Broadcast" size="6xl" color="text-homeblue-300" />
      <h1 class="fields text-[32px] md:text-[64px] text-text-default">Liveopdateringer</h1>
    </div>
    <p class="md:max-w-[75%] font-semibold text-center">
      På denne side findes en liste med Homerunners liveopdateringer. De opdateres løbende, når de bliver løst.
    </p>

    <div class="self-start">
      <p class="text-lg mb-2">Filtrer efter kategori:</p>
      <div class="text-lg flex gap-4">
        <button
          :class="['py-2 px-4 transition duration-500 rounded shadow-lg flex items-center font-medium gap-2', filters.countries ? 'bg-home-kiwi-200 border border-home-kiwi-300' : 'bg-home-kiwi border border-home-kiwi']"
          @click="toggleFilter('countries')">
          Lande
          <Icon v-if="filters.countries" src="Check" size="lg" color="text-home-kiwi-300" />
        </button>

        <button
          :class="['py-2 px-4 transition duration-500 rounded shadow-lg flex items-center font-medium gap-2', filters.carriers ? 'bg-home-tangerine-200 border border-home-tangerine-300' : 'bg-home-tangerine border border-home-tangerine']"
          @click="toggleFilter('carriers')">
          Transportører
          <Icon v-if="filters.carriers" src="Check" size="lg" color="text-home-tangerine-300" />
        </button>

        <button
          :class="['py-2 px-4 transition duration-500 rounded shadow-lg flex items-center font-medium gap-2', filters.services ? 'bg-home-grape-200 border border-home-grape-300' : 'bg-home-grape border border-home-grape']"
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

    <div v-if="filteredIncidents.length === 0" class="text-center text-2xl fields text-homeblue-300 mt-20 mb-40">
      Der er ingen liveopdateringer med de valgte filtre.
    </div>

    <div v-else v-for="incident in filteredIncidents" :key="incident.incident_id" class="w-full">
      <Incident :incident="incident" :editAllowed="true" />
    </div>
  </div>
</template>

<script setup lang="ts">
import { useIncidents } from '@/composables/useIncidents';

interface Filters {
  resolved: boolean;
  carriers: boolean;
  countries: boolean;
  services: boolean;
}

const { incidents, fetchIncidents } = useIncidents();

const filters = ref<Filters>({
  resolved: false,  // If checked, show only unresolved incidents
  carriers: false,  // Show incidents with carriers
  countries: false, // Show incidents with countries
  services: false,  // Show incidents with services
});

onMounted(() => {
  fetchIncidents();
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
