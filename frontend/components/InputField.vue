<template>
    <div class="flex flex-col">
        <label v-if="label" class="text-lg mb-2">{{ label }}</label>

        <input 
            v-if="type !== 'textarea'" 
            :type="type" 
            :placeholder="placeholder" 
            :class="[
                'bg-[#F8F8F8] border-[#EBEBEB] text-[#9EA4AF] rounded-xl px-4 py-3',
                { 'w-fit': type === 'date' }
            ]" 
            :aria-label="label" />

        <textarea
            v-if="type === 'textarea'"
            :placeholder="placeholder"
            class="bg-[#F8F8F8] border-[#EBEBEB] text-[#9EA4AF] rounded-xl px-4 py-3 h-40 resize-none overflow-auto"
            :aria-label="label"
        ></textarea>
    </div>
</template>

<script setup lang="ts">
const props = defineProps({
    label: {
        type: String,
        required: false,
        default: '',
    },
    placeholder: {
        type: String,
        required: false,
        default: '',
    },
    type: {
        type: String,
        required: false,
        default: 'text',
    },
});
</script>

<style scoped>
textarea::placeholder {
    text-align: start;
    vertical-align: top;
}
</style>
