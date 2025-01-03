<template>
    <div class="bg-homeblue-08 rounded-2xl p-8 max-w-screen-md w-full mx-auto">
        <p class="text-homeblue-300">{{ formatDate(incident.created_at) }}</p>
        <p>LABEL</p>
        <h2 class="fields text-[24px] md:text-[32px] text-homeblue-300">{{ incident.title }}</h2>
        <p class="text-[20px] mt-2 text-homeblue-300">{{ incident.message }}</p>

        <div class="flex gap-4 mt-4 flex-wrap">
            <Tag v-if="incident.country != ''" v-for="countryCode in incident.country.split(',')" :key="countryCode"
                :text="getCountryName(countryCode)" type="country" />
            <Tag v-for="carrier in incident.carriers" :key="carrier.carrier_id" :text="carrier.title" type="carrier" />
            <Tag v-for="service in incident.services" :key="service.id" :text="service.description" type="service" />
        </div>
    </div>
</template>

<script setup lang="ts">
import countriesData from '~/public/countries.js';

const props = defineProps<{
    incident: IncidentType;
}>();

interface IncidentType {
    incident_id: number;
    title: string;
    message: string;
    country: string; // Country is a string of codes ("AF,AG")
    status: string;
    resolved_at?: string | null;
    expected_resolved_at?: string | null;
    created_at: string;
    updated_at: string;
    critical: number;
    type: string;
    services: { id: number; title: string, description: string }[];
    carriers: { carrier_id: number; title: string }[];
}

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

const getCountryName = (countryCode: string) => {
    const country = countriesData.COUNTRIES.find((country) => country.code === countryCode);
    return country ? country.name : countryCode; // return country name if found, otherwise return the code
};
</script>