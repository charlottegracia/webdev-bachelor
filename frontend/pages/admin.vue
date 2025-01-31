<template>
    <div>
        <div v-if="showSuccessMessage" :class="{
            'bg-home-kiwi-200 text-home-kiwi-300': isSuccess,
            'bg-red-200 text-red-500': !isSuccess
        }" class="font-semibold p-4 rounded-md mb-4 max-w-screen-md transition duration-500 mx-auto">
            <p>{{ successMessage }}</p>
        </div>
        <h2 class="text-4xl md:text-6xl fields text-center mb-5">Hvad vil du gerne oprette?</h2>
        <div class="rounded-3xl bg-white p-8 max-w-screen-md mx-auto flex flex-col gap-5">
            <div>
                <p class="text-lg mb-2">Type</p>
                <div class="flex gap-4">
                    <label
                        class="flex items-center justify-center gap-1 sm:gap-2 cursor-pointer px-4 sm:px-8 py-2 border rounded-xl transition duration-200 ease-in-out"
                        :class="{
                            'bg-[#F8F8F8] border-[#EBEBEB] text-text-default': selectedType !== 'incident',
                            'border-homeblue-100 bg-homeblue-08 text-homeblue-100': selectedType === 'incident'
                        }">
                        <input type="radio" name="type" value="incident" v-model="selectedType" class="hidden" />
                        <Icon src="Broadcast" size="2xl"
                            :color="selectedType === 'incident' ? 'text-homeblue-100' : 'text-text-default'"
                            class="mr-2" />
                        <span class="text-lg">Liveopdatering</span>
                    </label>
                    <label
                        class="flex items-center justify-center gap-1 sm:gap-2 cursor-pointer px-4 sm:px-8 py-2 border rounded-xl transition duration-200 ease-in-out"
                        :class="{
                            'bg-[#F8F8F8] border-[#EBEBEB] text-text-default': selectedType !== 'carrier',
                            'border-homeblue-100 bg-homeblue-08 text-homeblue-100': selectedType === 'carrier'
                        }">
                        <input type="radio" name="type" value="carrier" v-model="selectedType" class="hidden" />
                        <Icon src="Truck" size="2xl"
                            :color="selectedType === 'carrier' ? 'text-homeblue-100' : 'text-text-default'"
                            class="mr-2" />
                        <span class="text-lg">Transportør</span>
                    </label>
                </div>
            </div>

            <div v-if="selectedType === 'incident'" class="flex flex-col gap-6">
                <InputField v-model="incidentTitle" label="Titel *" placeholder="Indtast titel" type="text" />
                <InputField v-model="incidentDescription" label="Beskrivelse *" placeholder="Indtast beskrivelse"
                    type="textarea" />
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex gap-1">
                            <Icon src="GlobeHemisphereWest" size="2xl" class="mr-2" />
                            <p class="text-lg">Tilføj lande</p>
                        </div>
                        <button @click="resetCountries" class="text-sm mr-3 text-text-tertiary">
                            Nulstil
                        </button>
                    </div>
                    <div class="bg-[#F8F8F8] border-[#EBEBEB] rounded-xl py-4 px-6 max-h-48 overflow-y-scroll">
                        <div class="flex items-center gap-6 mb-2 border-b pb-2 w-1/3">
                            <input type="checkbox" :checked="isAllCountriesSelected" @change="toggleSelectAllCountries"
                                id="selectAllCountries" />
                            <span>Vælg alle</span>
                        </div>
                        <div v-for="country in countries" :key="country.code">
                            <div class="flex items-center gap-6">
                                <input type="checkbox" :id="country.code" :value="country"
                                    v-model="selectedCountries" />
                                <span>{{ country.name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex gap-1">
                            <Icon src="truck" size="2xl" class="mr-2" />
                            <p class="text-lg">Tilføj transportører</p>
                        </div>
                        <button @click="resetCarriers" class="text-sm mr-3 text-text-tertiary">
                            Nulstil
                        </button>
                    </div>
                    <div class="bg-[#F8F8F8] border-[#EBEBEB] rounded-xl py-4 px-6 max-h-48 overflow-y-scroll">
                        <div class="flex items-center gap-6 mb-2 border-b pb-2 w-1/3">
                            <input type="checkbox" :checked="isAllCarriersSelected" @change="toggleSelectAllCarriers"
                                id="selectAllCarriers" />
                            <span>Vælg alle</span>
                        </div>
                        <div v-for="carrier in carriers" :key="carrier.carrier_id">
                            <div class="flex items-center gap-6">
                                <input type="checkbox" :id="carrier.carrier_id.toString()" :value="carrier"
                                    v-model="selectedCarriers" />
                                <span>{{ carrier.title }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex gap-1">
                            <Icon src="graph" size="2xl" class="mr-2" />
                            <p class="text-lg">Tilføj services</p>
                        </div>
                        <button @click="resetServices" class="text-sm mr-3 text-text-tertiary">
                            Nulstil
                        </button>
                    </div>
                    <div class="bg-[#F8F8F8] border-[#EBEBEB] rounded-xl py-4 px-6 max-h-48 overflow-y-scroll">
                        <div class="flex items-center gap-6 mb-2 border-b pb-2 w-1/3">
                            <input type="checkbox" :checked="isAllServicesSelected" @change="toggleSelectAllServices"
                                id="selectAllServices" />
                            <span>Vælg alle</span>
                        </div>
                        <div v-for="service in services" :key="service.service_id">
                            <div class="flex items-center gap-6">
                                <input type="checkbox" :id="service.service_id.toString()" :value="service"
                                    v-model="selectedServices" />
                                <span>{{ service.description }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <InputField v-model="expectedResolution" label="Hvornår forventes problemet at være løst?"
                    type="date" />
                <div class="text-lg">
                    <div class="flex items-center gap-2">
                        <p>Er problemet kritisk?</p>
                        <Tooltip text="Ved valg af 'Kritisk' ændres status på valgt transportør/service/land til rød">
                            <Icon src="info" size="lg" />
                        </Tooltip>
                    </div>
                    <div class="flex gap-6">
                        <div class="flex gap-2">
                            <input type="radio" id="non-critical" value="0" v-model="selectedProblemStatus" />
                            <label for="non-critical">Ikke-kritisk</label>
                        </div>
                        <div class="flex gap-2">
                            <input type="radio" id="critical" value="1" v-model="selectedProblemStatus" />
                            <label for="critical">Kritisk</label>
                        </div>
                    </div>
                </div>
                <div class="bg-homeblue-08 rounded-lg">
                    <div class="flex items-center justify-between gap-4 px-6 py-4" @click="toggleAccordion">
                        <div class="flex items-center gap-4">
                            <Icon src="Broadcast" size="3xl" />
                            <p class="text-lg font-semibold">Preview på liveopdatering</p>
                        </div>

                        <Icon :src="showDetails ? 'MinusCircle' : 'PlusCircle'" size="2xl"
                            class="transition-all duration-300 transform" :class="showDetails ? 'rotate-180' : ''" />
                    </div>

                    <div class="accordion-content" :class="{ 'expanded': showDetails }">
                        <Incident :incident="previewIncident" :editAllowed="false" />
                    </div>
                </div>
                <Button text="Opret liveopdatering" @click="checkRequired" />
            </div>
            <div v-if="selectedType === 'carrier'" class="flex flex-col gap-4">
                <InputField v-model="carrierSlug" label="Slug *" placeholder="Indtast slug" type="text" />
                <InputField v-model="carrierTitle" label="Titel *" placeholder="Indtast titel" type="text" />
                <InputField v-model="carrierDescription" label="Beskrivelse" placeholder="Indtast beskrivelse"
                    type="textarea" />
                <Button text="Opret transportør" @click="checkRequired" />
            </div>
        </div>
        <ConfirmationModal :isVisible="showModal" :onConfirm="handleConfirmSubmission"
            :onCancel="handleCancelSubmission" :title="modalTitle" :button="modalButton" />
    </div>
</template>

<script setup lang="ts">
import type { Carrier, Country, Service, Incident } from '~/types.ts';
import { ref, computed, onMounted} from 'vue';
import { useIncidents } from '~/composables/useIncidents';
import { useCarriers } from '~/composables/useCarriers';
import { useCountries } from '~/composables/useCountries';
import { useServices } from '~/composables/useServices';

const incidentTitle = ref('');
const incidentDescription = ref('');
const carrierSlug = ref('');
const carrierTitle = ref('');
const carrierDescription = ref('');
const expectedResolution = ref('');
const selectedCountries = ref<Country[]>([]);
const selectedCarriers = ref<Carrier[]>([]);
const selectedServices = ref<Service[]>([]);
const selectedType = ref<'incident' | 'carrier'>('incident');
const selectedProblemStatus = ref<'0' | '1'>('0');
const showDetails = ref(false);
const showModal = ref(false);
const modalTitle = ref('Er du sikker på, at du vil oprette denne liveopdatering?');
const modalButton = ref('Opret liveopdatering');
const showSuccessMessage = ref(false);
const isSuccess = ref(true);
const successMessage = ref('');

const { postIncident } = useIncidents();
const { carriers, fetchCarriers, postCarrier } = useCarriers();
const { services, fetchServices } = useServices();
const { countries } = useCountries();

const isAllCountriesSelected = computed(() => selectedCountries.value.length === countries.value.length);
const isAllCarriersSelected = computed(() => selectedCarriers.value.length === carriers.value.length);
const isAllServicesSelected = computed(() => selectedServices.value.length === services.value.length);

// preview data of incident
const previewIncident = computed(() => ({
    title: incidentTitle.value || 'Ingen titel angivet',
    message: incidentDescription.value || 'Ingen beskrivelse angivet',
    country: selectedCountries.value.map(c => c.code).join(','),
    expected_resolved_at: expectedResolution.value || null,
    created_at: new Date().toISOString(),
    updated_at: new Date().toISOString(),
    critical: parseInt(selectedProblemStatus.value),
    services: selectedServices.value.map(s => ({
        id: s.service_id,
        title: s.title,
        description: s.description,
    })),
    carriers: selectedCarriers.value.map(c => ({
        carrier_id: c.carrier_id,
        title: c.title,
    })),
}));

const toggleSelectAllCountries = () => {
    selectedCountries.value = isAllCountriesSelected.value ? [] : [...countries.value];
};

const toggleSelectAllCarriers = () => {
    selectedCarriers.value = isAllCarriersSelected.value ? [] : [...carriers.value];
};

const toggleSelectAllServices = () => {
    selectedServices.value = isAllServicesSelected.value ? [] : [...services.value];
};

const resetCountries = () => {
    selectedCountries.value = [];
};

const resetCarriers = () => {
    selectedCarriers.value = [];
};

const resetServices = () => {
    selectedServices.value = [];
};

const toggleAccordion = () => {
    showDetails.value = !showDetails.value;
};

const checkRequired = () => {
    if (selectedType.value === 'incident') {
        if (!incidentTitle.value || !incidentDescription.value) {
            alert('Liveopdateringens titel og beskrivelse skal udfyldes.');
            return;
        }
        modalTitle.value = 'Er du sikker på, at du vil oprette denne liveopdatering?';
        modalButton.value = 'Opret liveopdatering';
    } else if (selectedType.value === 'carrier') {
        if (!carrierSlug.value || !carrierTitle.value) {
            alert('Transportørens slug og titel skal udfyldes.');
            return;
        }
        modalTitle.value = 'Er du sikker på, at du vil oprette denne transportør?';
        modalButton.value = 'Opret transportør';
    }

    showModal.value = true;
};

const handlePostCreationSuccess = (data: any) => {
    isSuccess.value = true;
    if (selectedType.value === 'incident') {
        successMessage.value = `Liveopdateringen blev oprettet.`;
        resetIncidentForm();
    } else if (selectedType.value === 'carrier') {
        successMessage.value = `Transportøren ${data.title} blev oprettet.`;
        resetCarrierForm();
    }

    showSuccessMessage.value = true;
    setTimeout(() => {
        showSuccessMessage.value = false;
    }, 10000);
};

const handleConfirmSubmission = async () => {
    showModal.value = false;
    let formData = {};

    if (selectedType.value === 'incident') {
        formData = {
            title: incidentTitle.value,
            message: incidentDescription.value,
            country: selectedCountries.value.map(c => c.code).join(','),
            carrier_ids: selectedCarriers.value.map(c => c.carrier_id),
            service_ids: selectedServices.value.map(s => s.service_id),
            expected_resolved_at: expectedResolution.value,
            critical: parseInt(selectedProblemStatus.value),
        };

        try {
            const incidentData = await postIncident(formData as Incident);
            handlePostCreationSuccess(incidentData);
        } catch (error) {
            handlePostCreationFailure();
        }
    } else if (selectedType.value === 'carrier') {
        formData = {
            slug: carrierSlug.value,
            title: carrierTitle.value,
            description: carrierDescription.value,
        };

        try {
            const carrierData = await postCarrier(formData as Carrier);
            handlePostCreationSuccess(carrierData);
        } catch (error) {
            handlePostCreationFailure();
        }
    }
};

const handlePostCreationFailure = () => {
    isSuccess.value = false;
    if (selectedType.value === 'incident') {
        successMessage.value = `Der opstod en fejl ved oprettelsen af liveopdateringen.`;
    } else if (selectedType.value === 'carrier') {
    successMessage.value = `Der opstod en fejl ved oprettelsen af transportør.`;
    }
    showSuccessMessage.value = true;
    setTimeout(() => {
        showSuccessMessage.value = false;
    }, 10000);
};

const resetIncidentForm = () => {
    incidentTitle.value = '';
    incidentDescription.value = '';
    selectedCountries.value = [];
    selectedCarriers.value = [];
    selectedServices.value = [];
    expectedResolution.value = '';
    selectedProblemStatus.value = '0';
};

const resetCarrierForm = () => {
    carrierSlug.value = '';
    carrierTitle.value = '';
    carrierDescription.value = '';
};

const handleCancelSubmission = () => {
    showModal.value = false;
};

onMounted(async () => {
    await fetchServices();
    await fetchCarriers();
});
</script>


<style scoped>
.accordion-content {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s ease-in-out;
}

.accordion-content.expanded {
    max-height: 500px;
}
</style>
