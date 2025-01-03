<template>
    <div class="group relative w-fit">
        <VTooltip :placement="placement" class="h-[inherit]">
            <div class="peer h-[inherit]">
                <slot>
                    <Icon src="info"></Icon>
                </slot>
            </div>

            <template #popper>
                <div class="bg-white shadow rounded-[4px] px-4 py-2">
                    <p class="text-text-default text-sm tracking-[0.26px]">
                        <slot name="header">
                            {{ text }}
                        </slot>
                    </p>
                    <slot name="body"></slot>
                </div>
            </template>
        </VTooltip>
    </div>
</template>

<script setup lang="ts">
const props = withDefaults(
    defineProps<{
        text: string;
        placement?: 'auto' | 'auto-start' | 'auto-end' | 'top' | 'top-start' | 'top-end' | 'right' | 'right-start' | 'right-end' | 'bottom' | 'bottom-start' | 'bottom-end' | 'left' | 'left-start' | 'left-end';
    }>(),
    {
        placement: 'top',

    }
);

</script>