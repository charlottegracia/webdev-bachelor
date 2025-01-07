<template>
  <div class="flex flex-col gap-8">
    <div class="flex gap-8 items-center">
      <Icon src="Truck" size="6xl" color="text-homeblue-300"/>
      <h1 class="fields text-[32px] md:text-[64px] text-text-default">Transportører</h1>
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
const { carriers, fetchCarriers } = useCarriers();

function sortCarriersByName(carriers) {
  return carriers.sort((a, b) => {
    const nameA = a.title || ''; // empty string as if title is missing
    const nameB = b.title || '';
    return nameA.localeCompare(nameB);
  });
}

// Computed properties to separate and sort carriers
const carriersWithIncidents = computed(() => 
  sortCarriersByName(
    carriers.value.filter(carrier => carrier.incidents && carrier.incidents.length > 0)
  )
);
const carriersWithoutIncidents = computed(() => 
  sortCarriersByName(
    carriers.value.filter(carrier => !carrier.incidents || carrier.incidents.length === 0)
  )
);

onMounted(async () => {
  await fetchCarriers();
});
</script>
