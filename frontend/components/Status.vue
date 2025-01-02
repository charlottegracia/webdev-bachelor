<template>
    <div class="flex items-center gap-2">
        <div
            :class="[
            'w-3 h-3 rounded-full',
            statusClass
            ]"
        ></div>
        <p>Status</p>
    </div>
</template>
  
<script setup lang="ts">
import { computed } from 'vue';
  
interface Props {
    status: 'green' | 'yellow' | 'red' | string; 
}
  
const props = defineProps<Props>();
  
  // Computed property to determine the class based on the status
const statusClass = computed(() => {
    switch (props.status.toLowerCase()) {
        case 'green':
            return 'bg-[#3CC834]';
        case 'yellow':
            return 'bg-[#F2CB3D]';
        case 'red':
            return 'bg-[#E16262]';
        default:
            return 'bg-gray-400'; // default for unknown status
    }
});
  
</script>
  