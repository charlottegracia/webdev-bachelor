<template>
    <div class="flex flex-col">
        <label v-if="label" class="text-lg mb-2">{{ label }}</label>
        <input 
            v-if="type !== 'textarea'" 
            v-model="modelValue"
            :type="type" 
            :placeholder="placeholder" 
            :class="[
                'bg-[#F8F8F8] border-[#EBEBEB] rounded-xl px-4 py-3',
                { 'w-fit': type === 'date' }
            ]" 
            :aria-label="label" />
        <textarea
            v-if="type === 'textarea'"
            v-model="modelValue"
            :placeholder="placeholder"
            class="bg-[#F8F8F8] border-[#EBEBEB] rounded-xl px-4 py-3 h-40 resize-none overflow-auto"
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

const emit = defineEmits(['update:modelValue']);
const modelValue = ref('');

// Sanitize input to ensure no HTML or script tags are allowed, by not allowing characters in between the < and > symbols
function sanitizeInput(input: string): string {
    const sanitizedInput = input.match(/^(?!.*<[^>]+>).*$/)?.[0] || ''; 
    return sanitizedInput;
}

watch(modelValue, (newValue) => {
    const sanitizedValue = sanitizeInput(newValue); 
    emit('update:modelValue', sanitizedValue); 
    // Update `modelValue` if the sanitization changed the input 
    if (sanitizedValue !== newValue) {
        modelValue.value = sanitizedValue;
    }
});
</script>

<style scoped>
textarea::placeholder {
    text-align: start;
    vertical-align: top;
}
</style>
