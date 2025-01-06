<template>
    <div class="inline-block text-md">
        <div v-if="props.type === 'date'" :class="['rounded', sizeClass, colorClass]">
            <span v-if="props.incident?.resolved_at">
                Problemet er løst {{ formatDate(props.incident.resolved_at, true) }}
            </span>
            <span v-else-if="props.incident?.expected_resolved_at">
                Forventes løst {{ formatDate(props.incident.expected_resolved_at) }}
            </span>
            <span v-else>
                Ingen dato tilgængelig
            </span>
        </div>

        <a v-else-if="props.type === 'link'" :href="'/updates'" :class="[sizeClass]"
            class="flex items-center w-full rounded text-homeblue-300 bg-homeblue-12">
            <div v-if="props.size === 'sm'" class="flex items-center w-full">
                <Icon :src="'info'" :size="'lg'" :color="'text-homeblue-300'" class="mr-2" />
                <p class="truncate flex-1">
                    {{ props.incident?.title || 'Vis opdateringer' }}
                </p>
                <Icon :src="'arrowRight'" :size="'lg'" :color="'text-homeblue-300'" class="ml-8" />
            </div>

            <div v-else-if="props.size === 'lg'" class="flex items-center w-full">
                <p v-if="props.incident && props.incident.updated_at" class="whitespace-nowrap">
                    {{ formatDate(props.incident.updated_at) + ' - ' }}
                </p>
                <p class="truncate flex-1">
                    {{ props.incident?.title || 'Vis opdateringer' }}
                </p>
            </div>
        </a>

    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Incident } from '~/composables/useIncidents'; 

const props = withDefaults(defineProps<{
    type: 'date' | 'link';
    incident: Incident;
    size?: 'sm' | 'lg';
}>(), {
    size: 'sm'
});

const sizeClass = computed(() => (props.size === 'lg' ? 'py-3 px-4 rounded-xl' : 'py-1 px-2 text-sm'));

const colorClass = computed(() => {
    if (props.incident?.resolved_at) {
        return 'bg-homeblue-300 text-white'; 
    } else if (props.incident?.expected_resolved_at) {
        return 'bg-homeblue-12 text-homeblue-300'; 
    }
});

const formatDate = (dateString?: string, withTime?: boolean) => {
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

    if (withTime === true) {
        return `${dateFormatted} ${timeFormatted}`;
    }
    else {
        return `${dateFormatted}`;
    }
};
</script>