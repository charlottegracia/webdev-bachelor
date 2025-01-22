<template>
    <div class="flex flex-col gap-8">
        <div class="flex gap-8 items-center">
            <Icon src="Graph" size="6xl" color="text-homeblue-300"/>
            <h1 class="fields text-[32px] md:text-[64px] text-text-default">{{ $t('services') }}</h1>
        </div>
        <p class="md:max-w-[75%] font-semibold">{{ $t('services_text') }}</p>
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
const { services, fetchServices } = useServices();

function filterActiveIncidents(incidents) {
    return incidents.filter(incident => incident.status !== 'expired');
}

// Computed properties to separate and sort services
const servicesWithIncidents = computed(() =>
    services.value.filter(service => {
        if (service.incidents && service.incidents.length > 0) {
            service.incidents = filterActiveIncidents(service.incidents);
            return service.incidents.length > 0;
        }
        return false;
    })
);
const servicesWithoutIncidents = computed(() =>
    services.value.filter(service => !service.incidents || filterActiveIncidents(service.incidents).length === 0)
);

onMounted(async () => {
    await fetchServices();
});
</script>