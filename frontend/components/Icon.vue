<template>
    <div>
      <component
        v-if="iconComponent"
        :is="iconComponent"
        :class="['icon', iconSizeClasses, iconColorClasses]"
        :style="iconColorStyle"
        :weight="weight"
      />
    </div>
  </template>
  <script setup lang="ts">
  import { computed } from 'vue';
  
  // Import Phosphor icons you want to use
  import {
    PhTruck,
    PhGlobeHemisphereWest,
    PhArrowRight,
    PhGraph,
    PhBroadcast,
    PhCalendar,
    // Add more icons here as needed
  } from '@phosphor-icons/vue/compact';
  
  // Mapping Phosphor icons to their components
  const icons: Record<string, Component> = {
    PhTruck,
    PhGlobeHemisphereWest,
    PhArrowRight,
    PhGraph,
    PhBroadcast,
    PhCalendar,
    // Add more icons here as needed
  };
  
  // Define the props
  const props = withDefaults(
    defineProps<{
      size?: 'sm' | 'md' | 'lg' | 'xl' | '2xl' | '3xl' | '4xl' | '5xl' | '6xl';
      src?: string;
      color?: string; // New color prop
    }>(),
    {
      size: 'md',
      src: '',
      color: 'text-text-default', // Default value is an empty string
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
  const weight = computed(() => 'regular'); // Set all icons to regular weight
  
  // Generate inline style for color (if provided as a hex/RGB string)
  const iconColorStyle = computed(() => {
    if (props.color && !props.color.startsWith('text-')) {
      return { color: props.color }; // Apply custom color (e.g., #16405F or rgb(255, 0, 0))
    }
    return {}; // No inline style if no custom color is provided
  });
  
  // Generate Tailwind classes for color (if provided as a Tailwind color class)
  const iconColorClasses = computed(() => {
    if (props.color && props.color.startsWith('text-')) {
      return props.color; // Apply Tailwind CSS color class (e.g., text-red-500)
    }
    return ''; // No Tailwind class if not a valid text- color class
  });
  </script>
  