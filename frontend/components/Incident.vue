<template>
    <div class="bg-homeblue-08 rounded-2xl p-8 max-w-screen-md w-full mx-auto">
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-homeblue-300">{{ formatDate(incident.created_at) }}</p>
                <div v-if="editAllowed" class="flex gap-3">
                    <div @click="openModal('resolve')" class="cursor-pointer">
                        <Tooltip :text="$t('mark_as_solved')" placement="top">
                            <Icon src="CheckCircle" size="3xl" color="text-homeblue-300"
                                v-if="incident.resolved_at === null" />
                        </Tooltip>
                    </div>
                    <div @click="openModal('delete')" class="cursor-pointer">
                        <Tooltip :text="$t('delete_incident')" placement="top">
                            <Icon src="Trash" size="3xl" color="text-homeblue-300" />
                        </Tooltip>
                    </div>
                </div>
            </div>
            <Label v-if="incident.expected_resolved_at || incident.resolved_at" :type="'date'" :incident="incident"
                class="w-fit" />
            <h2 class="fields text-[24px] md:text-[32px] text-homeblue-300">{{ incident.title }}</h2>
            <p class="incident-message text-[20px] text-homeblue-300">{{ incident.message }}</p>
        </div>

        <div class="flex gap-3 mt-4 flex-wrap">
            <div v-if="incident.country && incident.country !== ''" v-for="countryCode in incident.country.split(',')"
                :key="countryCode">
                <Tag :text="getCountryName(countryCode)" type="country" />
            </div>
            <Tag v-for="carrier in incident.carriers" :key="carrier.carrier_id" :text="carrier.title" type="carrier" />
            <Tag v-for="service in incident.services" :key="service.service_id" :text="service.description" type="service" />
        </div>
    </div>

    <ConfirmationModal :isVisible="showModal" :onConfirm="onConfirmAction" :onCancel="handleCancelSubmission"
        :title="modalTitle" :button="modalButton" :actionType="actionType" />
</template>
<script setup lang="ts">
import { ref } from 'vue';
import type { Incident } from '../types.ts';
import { useIncidents } from '../composables/useIncidents';
import { useCountries } from '../composables/useCountries';
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const { resolveIncident, deleteIncident } = useIncidents();
const { countries } = useCountries();

const props = defineProps<{
    incident: Incident;
    editAllowed: boolean;
}>();

const showModal = ref(false);
const modalTitle = ref();
const modalButton = ref();
const actionType = ref<string>(''); // Store type of action ('resolve' or 'delete')

// Format date for display
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

// Get the country name based on the code
const getCountryName = (countryCode: string) => {
    const country = countries.value.find((country) => country.code === countryCode);
    return country ? country.name : countryCode; // Return country name if found, otherwise return the code
};

// Open confirmation modal
const openModal = (action: string) => {
    actionType.value = action; // Set action type ('resolve' or 'delete')
    if (action === 'delete') {
        modalTitle.value = t('delete.incident.confirmation');
        modalButton.value = t('delete.incident.button');
    } else if (action === 'resolve') {
        modalTitle.value = t('resolve.incident.confirmation');
        modalButton.value = t('resolve.incident.button');
    }
    showModal.value = true; // Show the modal
};

// Handle modal confirmation
const onConfirmAction = async () => {
    if (actionType.value === 'resolve') {
        await handleResolveIncident();
    } else if (actionType.value === 'delete') {
        await handleDeleteIncident();
    }
    showModal.value = false;
};

// Cancel the modal submission
const handleCancelSubmission = () => {
    showModal.value = false;
};

const formatMySQLDate = (date: Date): string => {
    return date.toISOString().slice(0, 19).replace('T', ' ');
};

// Resolve the incident
const handleResolveIncident = async () => {
    try {
        const resolvedAt = formatMySQLDate(new Date());
        const incidentId = props.incident.incident_id;

        await resolveIncident(incidentId, resolvedAt);

        // Update the resolved_at field locally
        props.incident.resolved_at = resolvedAt.toString();
    } catch (error) {
        console.error('Error marking incident as resolved:', error);
    }
};

// Delete the incident
const handleDeleteIncident = async () => {
    try {
        const incidentId = props.incident.incident_id;

        await deleteIncident(incidentId);

        location.reload();
    } catch (error) {
        console.error('Error deleting incident:', error);
    }
};
</script>
