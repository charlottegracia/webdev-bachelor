<template>
    <div class="flex flex-col gap-8">
        <div class="flex gap-8 items-center">
            <Icon src="Graph" size="6xl" color="text-homeblue-300"/>
            <h1 class="fields text-[32px] md:text-[64px] text-text-default">IT-services</h1>
        </div>
        <p class="md:max-w-[75%] font-semibold">Her kan du se status for Homerunners forskellige transportører</p>
        <div class="flex flex-col gap-4">
            <ul v-if="servicesWithIncidents.length > 0" class="flex flex-col gap-4 border-b border-b-homeblue-12 pb-4">
                <li v-for="service in servicesWithIncidents" :key="service.service_id">
                    <Service :service="service" />
                </li>
            </ul>
            <ul v-if="servicesWithoutIncidents.length > 0" class="flex flex-col gap-4">
                <li v-for="service in servicesWithoutIncidents" :key="service.service_id">
                    <Service :service="service" />
                </li>
            </ul>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

const services = ref([]);
const config = useRuntimeConfig();

// Computed properties to separate services
const servicesWithIncidents = computed(() =>
    services.value.filter(service => service.incidents && service.incidents.length > 0)
);
const servicesWithoutIncidents = computed(() =>
    services.value.filter(service => !service.incidents || service.incidents.length === 0)
);

onMounted(async () => {
    try {
        const { data } = await axios.get(`${config.public.apiBase}/services`);
        services.value = data;
    } catch (error) {
        console.error('Fejl ved hentning af services:', error);
    }
});
</script>