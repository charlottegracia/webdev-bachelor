<template>
    <div>
        <div v-if="showSuccessMessage" class="bg-home-kiwi-200 text-home-kiwi-300 font-semibold p-4 rounded-md mb-4 max-w-screen-md transition duration-500 mx-auto">
            <p>{{ successMessage }}</p>
        </div>
        <h2 class="text-6xl fields text-center mb-5">Hvad vil du gerne oprette?</h2>
        <div class="rounded-3xl bg-white p-8 max-w-screen-md mx-auto flex flex-col gap-5">
            <div>
                <p class="text-lg mb-2">Type</p>
                <div class="flex gap-4">
                    <label
                        class="flex items-center justify-center gap-2 cursor-pointer px-8 py-2 border rounded-xl transition duration-200 ease-in-out"
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
                        class="flex items-center justify-center gap-2 cursor-pointer px-8 py-2 border rounded-xl transition duration-200 ease-in-out"
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
                        <Tooltip text="Ved valg af 'Kritisk' ændres status på valgt transportør/service/land til rød" />
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
                    <div class="FIRST flex items-center justify-between gap-4 px-6 py-4" @click="toggleAccordion">
                        <div class="flex items-center gap-4">
                            <Icon src="Broadcast" size="3xl" />
                            <p class="text-lg font-semibold">Preview på liveopdatering</p>
                        </div>

                        <Icon :src="showDetails ? 'MinusCircle' : 'PlusCircle'" size="2xl"
                            class="transition-all duration-300 transform" :class="showDetails ? 'rotate-180' : ''" />
                    </div>

                    <div class="accordion-content" :class="{ 'expanded': showDetails }">
                        <div class="px-6 py-4">
                            <div class="mb-4 fields text-3xl">
                                <p v-if="incidentTitle">{{ incidentTitle }}</p>
                                <p v-else>Ingen titel angivet</p>
                            </div>
                            <div class="mb-4">
                                <p v-if="incidentDescription">{{ incidentDescription }}</p>
                                <p v-else>Ingen beskrivelse angivet</p>
                            </div>
                            <p>TAGS</p>
                            <div class="mb-4">
                                <p class="font-semibold">Valgte lande:</p>
                                <ul>
                                    <li v-for="country in selectedCountries" :key="country.code">{{ country.name }}</li>
                                </ul>
                            </div>
                            <div class="mb-4">
                                <p class="font-semibold">Valgte transportører:</p>
                                <ul>
                                    <li v-for="carrier in selectedCarriers" :key="carrier.carrier_id">{{ carrier.title
                                        }}</li>
                                </ul>
                            </div>
                            <div class="mb-4">
                                <p class="font-semibold">Valgte services:</p>
                                <ul>
                                    <li v-for="service in selectedServices" :key="service.service_id">{{ service.title
                                        }}</li>
                                </ul>
                            </div>
                            <div v-if="expectedResolution" class="mb-4">
                                <p class="font-semibold">Forventet løsningsdato:</p>
                                <p>{{ expectedResolution }}</p>
                            </div>
                            <div>
                                <p class="font-semibold">Problemets status:</p>
                                <p>{{ selectedProblemStatus === '1' ? 'Kritisk' : 'Ikke-kritisk' }}</p>
                            </div>
                        </div>
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
            :onCancel="handleCancelSubmission" :title="modalTitle" />
    </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import countriesData from '~/public/countries.js';
import axios from 'axios';
const config = useRuntimeConfig();

interface Country {
    name: string;
    code: string;
}

interface Carrier {
    carrier_id: number;
    title: string;
}

interface Service {
    service_id: number;
    title: string;
    description: string;
}

const incidentTitle = ref('');
const incidentDescription = ref('');
const carrierSlug = ref('');
const carrierTitle = ref('');
const carrierDescription = ref('');
const expectedResolution = ref('');
const countries = countriesData.COUNTRIES as Country[];
const carriers = ref<Carrier[]>([]);
const services = ref<Service[]>([]);
const selectedCountries = ref<Country[]>([]);
const selectedCarriers = ref<Carrier[]>([]);
const selectedServices = ref<Service[]>([]);
const selectedType = ref('incident');
const selectedProblemStatus = ref('0');
const showDetails = ref(false);
const showModal = ref(false); // Control modal visibility
const modalTitle = ref('Liveopdatering');
const showSuccessMessage = ref(false);
const successMessage = ref('');

const isAllCountriesSelected = computed(() => selectedCountries.value.length === countries.length);
const isAllCarriersSelected = computed(() => selectedCarriers.value.length === carriers.value.length);
const isAllServicesSelected = computed(() => selectedServices.value.length === services.value.length);

const toggleSelectAllCountries = () => {
    selectedCountries.value = isAllCountriesSelected.value ? [] : [...countries];
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

const checkRequired = async () => {
    if (selectedType.value === 'incident') {
        // Check if incident title and description are filled
        if (!incidentTitle.value || !incidentDescription.value) {
            alert('Liveopdateringens titel og beskrivelse skal udfyldes.');
            return;
        }
        modalTitle.value = 'Liveopdatering';
    } else if (selectedType.value === 'carrier') {
        // Check if carrier slug and title are filled
        if (!carrierSlug.value || !carrierTitle.value) {
            alert('Transportørens slug og titel skal udfyldes.');
            return;
        }
        modalTitle.value = 'Transportør';
    }

    showModal.value = true;
};

const handlePostCreationSuccess = (data: any) => {
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
    }, 3000);
};

// Confirm form submission after modal confirmation
const handleConfirmSubmission = async () => {
    showModal.value = false;
    // Initialize formData based on the selected type (incident or carrier)
    let formData = {};

    if (selectedType.value === 'incident') {
        formData = {
            title: incidentTitle.value,
            message: incidentDescription.value,
            country: selectedCountries.value.map(c => c.code).toString(),
            carrier_ids: selectedCarriers.value.map(c => c.carrier_id),
            service_ids: selectedServices.value.map(s => s.service_id),
            expected_resolved_at: expectedResolution.value,
            critical: selectedProblemStatus.value === '1',
        };
    } else if (selectedType.value === 'carrier') {
        formData = {
            slug: carrierSlug.value,
            title: carrierTitle.value,
            description: carrierDescription.value,
        };
    }

    // Choose endpoint based on the selected type
    const endpoint = selectedType.value === 'incident' ? '/incidents' : '/carriers';

    try {
        const { data } = await axios.post(`${config.public.apiBase}${endpoint}`, formData);
        handlePostCreationSuccess(data);
    } catch (error) {
        console.error(`Error creating ${selectedType.value}:`, error);
        successMessage.value = `Der opstod en fejl ved oprettelsen af ${selectedType.value}.`;
        showSuccessMessage.value = true;
        setTimeout(() => {
            showSuccessMessage.value = false;
        }, 3000);
    }
};

// Reset forms after successful submission
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
    try {
        const { data } = await axios.get(`${config.public.apiBase}/carriers`);
        carriers.value = data;
        const { data: serviceData } = await axios.get(`${config.public.apiBase}/services`);
        services.value = serviceData;
    } catch (error) {
        console.error('Fejl ved hentning af transportører:', error);
    }
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
