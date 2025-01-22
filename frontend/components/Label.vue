<template>
    <div class="inline-block text-md">
        <div v-if="props.type === 'date'" :class="['rounded', sizeClass, colorClass]" v-show="hasDate">
            <span v-if="props.incident?.resolved_at">
                {{ $t('label.solved') }} {{ formatDate(props.incident.resolved_at, true) }}
            </span>
            <span v-else-if="props.incident?.expected_resolved_at">
                {{ $t('label.expected_solved') }} {{ formatDate(props.incident.expected_resolved_at) }}
            </span>
        </div>

        <a v-else-if="props.type === 'link'" :href="'/updates'" :class="[
            'flex items-center w-full rounded text-homeblue-300', sizeClass,
            props.size === 'sm' ? 'bg-homeblue-08' : 'bg-homeblue-12'
        ]">
            <div v-if="props.size === 'sm'" class="flex items-center w-full">
                <Icon :src="'info'" :size="'lg'" :color="'text-homeblue-300'" class="mr-2" />
                <p class="truncate flex-1">
                    {{ props.incident?.title || $t('label.view_updates') }}
                </p>
                <Icon :src="'arrowRight'" :size="'lg'" :color="'text-homeblue-300'" class="ml-3" />
            </div>

            <div v-else-if="props.size === 'lg'" class="flex items-center w-full gap-1">
                <p v-if="props.incident && props.incident.updated_at" class="whitespace-nowrap">
                    {{ formatDate(props.incident.updated_at) }}
                </p>
                <span>-</span>
                <p class="truncate flex-1">
                    {{ props.incident?.title || $t('label.view_updates') }}
                </p>
            </div>
        </a>

    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Incident } from '~/types.ts';

const props = withDefaults(defineProps<{
    type: 'date' | 'link';
    incident: Incident;
    size?: 'sm' | 'lg';
}>(), {
    size: 'sm'
});

const hasDate = computed(() => {
  return props.incident?.resolved_at || props.incident?.expected_resolved_at;
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