<template>
  <div>
    <component v-if="iconComponent" :is="iconComponent" :class="['icon', iconSizeClasses, iconColorClasses]"
      :style="iconColorStyle" :weight="weight" />
  </div>
</template>
<script setup lang="ts">
import { computed } from 'vue';

import {
  PhTruck,
  PhGlobeHemisphereWest,
  // Add more icons here as needed
} from '@phosphor-icons/vue/compact';

const icons: Record<string, Component> = {
  PhTruck,
  PhGlobeHemisphereWest,
  // Add more icons here as needed
};


const props = withDefaults(
  defineProps<{
    size?: 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl';
    src?: string;
    color?: string;
  }>(),
  {
    size: 'md',
    src: '',
    color: 'text-text-default',
  }
);

// Dynamically resolve the icon based on the `src` prop
const iconComponent = computed(() => {
  const name = props.src ? `Ph${props.src.charAt(0).toUpperCase() + props.src.slice(1)}` : null;
  return name && icons[name] ? icons[name] : null;
});

// Size classes based on the `size` prop
const iconSizeClasses = computed(() => {
  const size = props.size || 'md';
  const sizeClasses = {
    'sm': 'text-sm',
    'md': 'text-base',
    'lg': 'text-lg',
    'xl': 'text-xl',
    '2xl': 'text-2xl',
    '3xl': 'text-3xl',
    '4xl': 'text-4xl',
    '5xl': 'text-5xl',
    '6xl': 'text-6xl',
  };
  return sizeClasses[size] || 'text-base';
});

// Always set weight to "regular"
const weight = computed(() => 'regular');

// Generate inline style for color (if provided as a hex/RGB string)
const iconColorStyle = computed(() => {
  if (props.color && !props.color.startsWith('text-')) {
    return { color: props.color };
  }
  return {};
});

// Generate Tailwind classes for color (if provided as a Tailwind color class)
const iconColorClasses = computed(() => {
  if (props.color && props.color.startsWith('text-')) {
    return props.color;
  }
  return ''
});
</script>