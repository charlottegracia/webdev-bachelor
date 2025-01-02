<template>
    <div>
        <div class="flex flex-col gap-6">
            <div class="bg-white rounded-lg">
                <div class="flex items-center justify-between gap-4 px-6 py-7" @click="toggleAccordion">
                    <div class="w-1/2 flex items-center">
                        <div class="w-1/3">
                            <img v-if="carrier.slug" :src="`/carriers/${carrier.slug}.png`" :alt="carrier.title"
                                class="h-6 object-contain" />
                        </div>
                        <p class="w-1/3 font-semibold">{{ carrier.title }}</p>
                        <p class="w-1/3">{{ carrier.status }}</p>
                    </div>
                    <div v-if="carrier.incidents.length > 0" class="flex justify-end items-center gap-4">
                        <div v-for="incident in carrier.incidents.slice(0, 2)" :key="incident.service_id"
                            class="text-xs">
                            <p>{{ incident.title }} LABEL COMPONENT</p>
                        </div>
                        <Icon :src="showDetails ? 'MinusCircle' : 'PlusCircle'" size="2xl"
                            class="transition-all duration-300 transform" :class="showDetails ? 'rotate-180' : ''" />
                    </div>
                </div>

                <div class="accordion-content" :class="{ 'expanded': showDetails }">
                    <div class="px-6">
                        <div class="flex flex-col">
                            <div class="flex py-3 border-t border-homeblue-12">
                                <div class="flex gap-4 items-center w-1/3">
                                    <Tooltip text="Oversigt over servicepoints" placement="top" size="md" />
                                    <p>Servicepoints</p>
                                </div>
                                <div class="w-1/6">status</div>
                            </div>
                            <div class="flex py-3 border-t border-homeblue-12">
                                <div class="flex gap-4 items-center w-1/3">
                                    <Tooltip text="Sporing af pakker" placement="top" size="md" />
                                    <p>Tracking</p>
                                </div>
                                <div class="w-1/6">status</div>
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
    carrier: {
        type: Object,
        required: true,
    },
});
const showDetails = ref(false);

const toggleAccordion = () => {
    showDetails.value = !showDetails.value;
};

onMounted(() => {
    console.log('Carrier:', props.carrier);
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