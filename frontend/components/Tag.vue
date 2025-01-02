<template>
    <div :class="['inline-block mr-4 text-base py-2 px-4 rounded-lg', backgroundColorClass, textColorClass]">
        {{ text }}
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps<{  
    text: string;
    type:'country' | 'carrier' | 'itService';
}>();

const typeColors: Record<string, { background: string; text: string }> = {
    country: {
        background: 'bg-home-kiwi',
        text: 'text-home-kiwi-300',
    },
    carrier: {
        background: 'bg-home-tangerine',
        text: 'text-home-tangerine-300',
    },
    itService: {
        background: 'bg-home-grape',
        text: 'text-home-grape-300',
    },
};

const backgroundColorClass = computed(() => {
    const color = typeColors[props.type];
    return color.background;
});

const textColorClass = computed(() => {
    const color = typeColors[props.type];
    return color.text;
})
</script>