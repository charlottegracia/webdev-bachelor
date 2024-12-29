<template>
    <div class="pt-40">
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
                <InputField label="Titel" placeholder="Indtast titel" type="text" />
                <InputField label="Beskrivelse" placeholder="Indtast beskrivelse" type="textarea" />
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
                            <Icon src="truck" size="2xl" class="mr-2" />
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
                                <span>{{ service.title }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <InputField label="Hvornår forventes problemet at være løst?" type="date" />
                <div class="text-lg">
                    <p><span>Er problemet kritisk?</span> <span>tooltip</span></p>
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
            </div>
            <div v-if="selectedType === 'carrier'" class="flex flex-col gap-4">
                <InputField label="Slug" placeholder="Indtast slug" type="text" />
                <InputField label="Titel" placeholder="Indtast titel" type="text" />
                <InputField label="Beskrivelse" placeholder="Indtast beskrivelse" type="textarea" />
            </div>
        </div>
    </div>
</template>
<script setup lang="ts">
import { ref, computed, onMounted, watch } from 'vue';
import countriesData from '~/public/countries.js';
import axios from 'axios';

// Interfaces
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
}

// Data
const countries = countriesData.COUNTRIES as Country[];
const carriers = ref<Carrier[]>([]);
const services = ref<Service[]>([]);
const selectedCountries = ref<Country[]>([]);
const selectedCarriers = ref<Carrier[]>([]);
const selectedServices = ref<Service[]>([]);
const selectedType = ref('incident');
const selectedProblemStatus = ref('0');

// Computed
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
    console.log('Countries selection has been reset');
};

const resetCarriers = () => {
    selectedCarriers.value = [];
    console.log('Carriers selection has been reset');
};

const resetServices = () => {
    selectedServices.value = [];
    console.log('Services selection has been reset');
};

// Watchers
watch(selectedCountries, (newValue) => {
    console.log('Selected countries:', newValue);
});

onMounted(async () => {
    try {
        const { data } = await axios.get('http://localhost:8000/api/carriers');
        carriers.value = data;
        console.log('Carriers:', carriers.value);
        const { data: serviceData } = await axios.get('http://localhost:8000/api/services');
        services.value = serviceData;
        console.log('Services:', services.value);
    } catch (error) {
        console.error('Fejl ved hentning af transportører:', error);
    }
});
</script>
