<template>
    <div>
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-lg">
                <div class="flex items-center justify-between gap-4 px-6 py-7" @click="toggleAccordion">
                    <div class="w-1/2 flex items-center">
                        <p class="w-1/2 font-semibold hidden md:block">{{ service.description }}</p>
                        <Status :status="service.status" class="w-1/2" />
                    </div>
                    <div class="flex justify-end items-center gap-4">
                        <div v-if="service.incidents.length > 0" v-for="incident in service.incidents.slice(0, 2)"
                            :key="incident.incident_id" class="text-xs">
                            <p class="truncate max-w-12 sm:max-w-24 md:max-w-40">{{ incident.title }} LABEL COMPONENT
                            </p>
                        </div>
                        <Icon v-if="service.services && service.services.length > 0" :src="showDetails ? 'MinusCircle' : 'PlusCircle'" size="2xl"
                            class="transition-all duration-300 transform" :class="showDetails ? 'rotate-180' : ''" />
                    </div>
                </div>

                <div class="accordion-content" :class="{ 'expanded': showDetails }">
                    <div class="px-6">
                        <div class="flex flex-col">
                            <div v-if="service.services && service.services.length > 0" v-for="service in service.services"
                                :key="service.service_id">
                                <div class="flex py-3 border-t border-homeblue-12">
                                    <div class="flex w-full md:w-1/2 justify-between lg:justify-normal">
                                        <div class="flex md:w-2/3 items-center gap-4">
                                            <Tooltip text="Oversigt over servicepoints" placement="top" size="md" />
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
const props = defineProps({
    service: {
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