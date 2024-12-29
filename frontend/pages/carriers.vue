<template>

    <div>transportører</div>
    <nuxt-link to="/">
        <Button text="Click fwetjygrbr br rf erb rwme" />
    </nuxt-link>

    <div>
        <div class="text-4xl pt-40">transportører</div>
        <!-- Using Tailwind CSS color class for Raspberry color -->
        <Icon src="Truck" size="sm" color="text-home-raspberry-200" />
    
        <!-- Using another Tailwind CSS color class -->
        <Icon src="GlobeHemisphereWest" size="6xl" color="text-home-kiwi" />

        <!-- Using a custom hex color -->
        <Icon src="Truck" size="md" color="#0456D1" />

        <!-- Using RGB color -->
        <Icon src="Truck" size="xl" color="rgb(255, 0, 0)" />

        <Icon src="Truck" size="4xl" />

        <ul v-if="carriers.length > 0">
      <li v-for="carrier in carriers" :key="carrier.carrier_id" class="my-2">
        <strong>{{ carrier.title }}</strong> - {{ carrier.type }} - {{ carrier.status }}
        <p>{{ carrier.description }}</p>
      </li>
    </ul>
    <p v-else>Ingen transportører fundet.</p>
    </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';  // Sørg for at importere axios

// Ref til at holde carrier-data
const carriers = ref([]);

// Hent data fra API'et når komponenten loader
onMounted(async () => {
  try {
    const { data } = await axios.get('http://localhost:8000/api/carriers');
    carriers.value = data;
  } catch (error) {
    console.error('Fejl ved hentning af transportører:', error);
  }
});
</script>