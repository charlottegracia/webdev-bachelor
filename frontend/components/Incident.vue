<template>
    <div class="bg-homeblue-08 rounded-2xl p-8 max-w-screen-md w-full mx-auto">
        <div class="flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <p class="text-homeblue-300">{{ formatDate(incident.created_at) }}</p>
                <div v-if="editAllowed" class="flex gap-3">
                    <div @click="openModal('resolve')" class="cursor-pointer">
                        <Tooltip :text="'Marker som løst'" placement="top">
                            <Icon src="CheckCircle" size="3xl" color="text-homeblue-300"
                                v-if="incident.resolved_at === null" />
                        </Tooltip>
                    </div>
                    <div @click="openModal('delete')" class="cursor-pointer">
                        <Tooltip :text="'Slet liveopdatering'" placement="top">
                            <Icon src="Trash" size="3xl" color="text-homeblue-300" />
                        </Tooltip>
                    </div>
                </div>
            </div>
            <Label v-if="incident.expected_resolved_at || incident.resolved_at" :type="'date'" :incident="incident" class="w-fit" />
            <h2 class="fields text-[24px] md:text-[32px] text-homeblue-300">{{ incident.title }}</h2>
            <p class="text-[20px] text-homeblue-300">{{ incident.message }}</p>
        </div>

        <div class="flex gap-3 mt-4 flex-wrap">
            <Tag v-if="incident.country != ''" v-for="countryCode in incident.country.split(',')" :key="countryCode"
                :text="getCountryName(countryCode)" type="country" />
            <Tag v-for="carrier in incident.carriers" :key="carrier.carrier_id" :text="carrier.title" type="carrier" />
            <Tag v-for="service in incident.services" :key="service.id" :text="service.description" type="service" />
        </div>
    </div>

    <ConfirmationModal :isVisible="showModal" :onConfirm="onConfirmAction" :onCancel="handleCancelSubmission"
        :title="modalTitle" :button="modalButton" :actionType="actionType" />
</template>

<script setup lang="ts">
import { ref } from 'vue';
import axios from 'axios';
import countriesData from '~/public/countries.js';

const props = defineProps<{
    incident: IncidentType;
    editAllowed: boolean;
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
    services: { id: number; title: string; description: string }[];
    carriers: { carrier_id: number; title: string }[];
}

const showModal = ref(false);
const modalTitle = ref('Er du sikker på, at du vil oprette denne liveopdatering?');
const modalButton = ref('Opret liveopdatering');
const actionType = ref<string>(''); // store type of action ('resolve' or 'delete')

const config = useRuntimeConfig();

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

// Helper function to format date for MySQL
const formatMySQLDate = (date: Date): string => {
    return date.toISOString().slice(0, 19).replace('T', ' ');
};

const openModal = (action: string) => {
    actionType.value = action; // Set action type ('resolve' or 'delete')
    if (action === 'delete') {
        modalTitle.value = 'Er du sikker på, at du vil slette denne liveopdatering?';
        modalButton.value = 'Slet liveopdatering';
    } else if (action === 'resolve') {
        modalTitle.value = 'Er du sikker på, at du vil markere denne liveopdatering som løst?';
        modalButton.value = 'Marker som løst';
    }
    showModal.value = true; // Show the modal
};

const onConfirmAction = async () => {
    if (actionType.value === 'resolve') {
        await markAsResolved();
    } else if (actionType.value === 'delete') {
        await deleteIncident();
    }
    showModal.value = false;
};

const handleCancelSubmission = () => {
    showModal.value = false;
};

const markAsResolved = async () => {
    try {
        const resolvedAt = formatMySQLDate(new Date());
        const incidentId = props.incident.incident_id;

        const response = await axios.put(
            `${config.public.apiBase}/incidents/${incidentId}`,
            { resolved_at: resolvedAt },
            {
                headers: {
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.status === 200) {
            // update incidents resolved_at value without reloading
            props.incident.resolved_at = resolvedAt;
        } else {
            throw new Error('Failed to mark incident as resolved');
        }
    } catch (error) {
        console.error('Error marking incident as resolved:', error);
    }
};

const deleteIncident = async () => {
    try {
        const incidentId = props.incident.incident_id;
        const response = await axios.delete(
            `${config.public.apiBase}/incidents/${incidentId}`,
            {
                headers: {
                    'Content-Type': 'application/json',
                },
            }
        );

        if (response.status === 200) {
            location.reload();
        } else {
            throw new Error('Failed to delete incident');
        }
    } catch (error) {
        console.error('Error deleting incident:', error);
    }
};
</script>
