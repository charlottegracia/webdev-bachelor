<template>
    <div
      :class="[
        'label inline-block rounded px-4 py-2',
        sizeClasses,
        type === 'date' ? dateColorClass : 'bg-link-blue text-white',
      ]"
    >
      <!-- Display content based on type -->
      <template v-if="type === 'date'">
        <span>{{ displayDate }}</span>
      </template>
      <template v-else-if="type === 'link'">
        <a href="/updates" class="text-white underline">{{ incident?.title || 'No Title' }}</a>
      </template>
    </div>
  </template>
  
  <script setup lang="ts">
  import { computed } from 'vue';
  import type { Incident } from '~/composables/useIncidents'; // Import Incident type
  
  // Props
  const props = withDefaults(
    defineProps<{
      type: 'date' | 'link';
      incident?: Incident; // Incident is optional to avoid runtime errors
      size?: 'sm' | 'lg';
    }>(),
    {
      size: 'sm',
    }
  );
  
  // Computed class for size
  const sizeClasses = computed(() => {
    return props.size === 'lg'
      ? 'text-lg py-3 px-6'
      : 'text-sm py-2 px-4';
  });
  
  // Computed class for date color
  const dateColorClass = computed(() => {
    if (!props.incident) return 'bg-gray-300'; // Fallback color
    if (props.incident.status === 'expired') {
      return 'bg-gray-400 text-white'; // Expired status
    }
    if (props.incident.resolved_at) {
      return 'bg-dark-blue text-white'; // Resolved
    }
    if (props.incident.expected_resolved_at) {
      return 'bg-light-blue text-dark-blue'; // Expected
    }
    return 'bg-gray-300 text-dark-gray'; // Default
  });
  
  // Computed display date
  const displayDate = computed(() => {
    if (!props.incident) return 'No date available'; // Fallback
    if (props.incident.resolved_at) {
      return `Resolved: ${new Date(props.incident.resolved_at).toLocaleDateString()}`;
    }
    if (props.incident.expected_resolved_at) {
      return `Expected: ${new Date(props.incident.expected_resolved_at).toLocaleDateString()}`;
    }
    return 'No date available';
  });
  </script>
  
  <style scoped>
  .bg-dark-blue {
    background-color: #002a5f;
  }
  .bg-light-blue {
    background-color: #a5d8ff;
  }
  .text-dark-blue {
    color: #002a5f;
  }
  .bg-link-blue {
    background-color: #0056b3;
  }
  .bg-gray-400 {
    background-color: #b0b0b0;
  }
  .text-dark-gray {
    color: #4a4a4a;
  }
  </style>
  