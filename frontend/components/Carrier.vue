<template>
    <div>
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-lg">
                <div class="flex items-center justify-between gap-4 px-6 py-7" @click="toggleAccordion">
                    <div class="w-1/2 flex items-center">
                        <div class="w-2/3 flex items-center gap-4">
                            <div class="w-1/2">
                                <img v-if="carrier && carrier.slug" :src="`/carriers/${carrier.slug}.png`" :alt="carrier.title"
                                    class="h-6 object-contain" />
                            </div>
                            <p class="w-1/2 font-semibold hidden md:block">{{ carrier?.title }}</p>
                        </div>
                        <Status v-if="carrier" :status="carrier.status" class="w-1/3"/>
                    </div>
                    <div class="flex justify-end items-center gap-4">
                        <div v-if="carrier && carrier.incidents.length > 0" v-for="incident in carrier.incidents.slice(0, 2)"
                            :key="incident.incident_id" class="text-xs">
                            <Label :type="'link'" :incident="incident" class="w-full hidden md:block sm:max-w-24 md:max-w-48"/>
                        </div>
                        <Icon v-if="carrier && carrier.services && carrier.services.length > 0" :src="showDetails ? 'MinusCircle' : 'PlusCircle'" size="2xl"
                            class="transition-all duration-300 transform" :class="showDetails ? 'rotate-180' : ''" />
                    </div>
                </div>

                <div class="accordion-content" :class="{ 'expanded': showDetails }">
                    <div class="px-6">
                        <div class="flex flex-col">
                            <div v-if="carrier && carrier.services && carrier.services.length > 0" v-for="service in carrier.services"
                                :key="service.service_id">
                                <div class="flex py-3 border-t border-homeblue-12">
                                    <div class="flex w-full md:w-1/2 justify-between lg:justify-normal">
                                        <div class="flex md:w-2/3 items-center gap-4">
                                            <Tooltip text="Oversigt over servicepoints">
                                                <Icon src="info" size="lg" />
                                            </Tooltip>
                                            <p>{{ service.title }}</p>
                                        </div>
                                        <Status :status="service.status" class="md:w-1/3"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps({
    carrier: {
        type: Object,
        required: true,
    },
});
const showDetails = ref(false);

const toggleAccordion = () => {
    showDetails.value = !showDetails.value;
};
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