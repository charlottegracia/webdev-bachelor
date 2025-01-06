<template>
  <div class="flex flex-col gap-8">
    <div class="flex gap-8 items-center">
      <Icon src="Truck" size="6xl" />
      <h1 class="fields text-[32px] md:text-[64px]">Transportører</h1>
    </div>
    <p class="md:max-w-[75%] font-semibold">Her kan du se status for Homerunners forskellige transportører</p>
    <div class="flex flex-col gap-4">
      <ul v-if="carriersWithIncidents.length > 0" class="flex flex-col gap-4 border-b border-b-homeblue-12 pb-4">
        <li v-for="carrier in carriersWithIncidents" :key="carrier.carrier_id">
          <Carrier :carrier="carrier" />
        </li>
      </ul>
      <ul v-if="carriersWithoutIncidents.length > 0" class="flex flex-col gap-4">
        <li v-for="carrier in carriersWithoutIncidents" :key="carrier.carrier_id">
          <Carrier :carrier="carrier" />
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const carriers = ref([]);
const config = useRuntimeConfig();

// Computed properties to separate carriers
const carriersWithIncidents = computed(() =>
  carriers.value.filter(carrier => carrier.incidents && carrier.incidents.length > 0)
);
const carriersWithoutIncidents = computed(() =>
  carriers.value.filter(carrier => !carrier.incidents || carrier.incidents.length === 0)
);

onMounted(async () => {
  try {
    const { data } = await axios.get(`${config.public.apiBase}/carriers`);
    carriers.value = data;
  } catch (error) {
    console.error('Fejl ved hentning af transportører:', error);
  }
});
</script>
