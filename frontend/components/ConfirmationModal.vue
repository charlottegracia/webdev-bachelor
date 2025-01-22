<template>
    <div v-if="isVisible" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[100]">
        <div class="bg-white p-6 rounded-lg max-w-md shadow-lg">
            <h3 class="text-xl font-semibold mb-2">{{ $t('are_you_sure') }}</h3>
            <p class="mb-4">{{ title }}</p>
            <div class="flex justify-center gap-4">
                <Button @click="confirm" :text="button" />
                <Button @click="cancel" :text="$t('cancel')" class="bg-white border border-homeblue-120 !text-homeblue-300" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue';

const props = defineProps({
    isVisible: {
        type: Boolean,
        required: true,
    },
    onConfirm: {
        type: Function,
        required: true,
    },
    onCancel: {
        type: Function,
        required: true,
    },
    title: {
        type: String,
        required: true,
    },
    button: {
        type: String,
        default: 'Opret',
    },
});

const confirm = () => {
    props.onConfirm();
};

const cancel = () => {
    props.onCancel();
};
</script>