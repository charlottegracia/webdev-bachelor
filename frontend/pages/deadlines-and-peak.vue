<template>
    <div class="flex flex-col gap-8">
        <div class="flex gap-8 items-center">
            <Icon src="Calendar" size="6xl" color="text-homeblue-300"/>
            <h1 class="fields text-[32px] md:text-[64px] text-text-default">{{ $t('deadlines_and_peak') }}</h1>
        </div>
        <p class="md:max-w-[75%] font-semibold">Beskrivelse</p>
        <div class="flex flex-col gap-4">
            Content
        </div>
    </div>
</template>