<template>
    <div class="bg-homeblue-08 rounded-2xl p-8 max-w-screen-md w-full mx-auto">
        <p class="text-homeblue-300">{{ formatDate(incident.created_at) }} mangler incident.created_at</p>
        <p>LABEL som viser incident.updated_at ?? måske</p>
        <h2 class="fields text-[24px] md:text-[32px] font-semibold text-homeblue-300">{{ incident.title }}</h2>
        <p class="text-[20px] mt-2 text-homeblue-300">{{ incident.message }}</p>

        <div class="flex gap-4 mt-4 flex-wrap">
            <!-- Loop through each country and pass the country title -->
            <Tag v-for="country in incident.country" :key="country.country_id" :text="country.title" type="country" />

            <!-- Loop through each carrier and pass the carrier title -->
            <Tag v-for="carrier in incident.carriers" :key="carrier.carrier_id" :text="carrier.title" type="carrier" />

            <!-- Loop through each service and pass the service title -->
            <Tag v-for="service in incident.services" :key="service.id" :text="service.title" type="service" />
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{
  incident: IncidentType;
}>();
interface IncidentType {
    incident_id: number;
    title: string;
    message: string;
    country: { country_id: number; title: string }[]; // Country must be an array of objects
    status: string;
    resolved_at?: string | null;
    expected_resolved_at?: string | null;
    created_at: string;
    updated_at: string;
    critical: number;
    type: string;
    services: { id: number; title: string }[];
    carriers: { carrier_id: number; title: string }[];
  }
  
const capitalize = (text: string) => text.charAt(0).toUpperCase() + text.slice(1);

const formatDate = (dateString?: string) => {
    if (!dateString) return null;
    const date = new Date(dateString);

    const optionsDate: Intl.DateTimeFormatOptions = {
        day: '2-digit',
        month: 'long',
        year: 'numeric',
    };

    const optionsTime: Intl.DateTimeFormatOptions = {
        hour: '2-digit',
        minute: '2-digit',
    };

    const dateFormatted = date.toLocaleDateString('da-DK', optionsDate);
    const timeFormatted = date.toLocaleTimeString('da-DK', optionsTime);

    return `${dateFormatted} ${timeFormatted}`;
};
</script>
