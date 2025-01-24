<template>
    <div>
        <h1 class="fields text-[64px] pb-12">{{ $t('frontpage.title') }}</h1>
        <section class="grid grid-cols-2 md:grid-cols-3 gap-7 w-full">
            <nuxt-link to="/updates" 
                class="bg-homeblue-08 text-homeblue-300 col-span-2 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            <Icon src="Broadcast" size="3xl" color="text-homeblue-300" />
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">{{ $t('incidents') }}</h2>
                    </div>
                    <p class="text-xl">{{ $t('frontpage.updates.text') }}</p>
                    <div class="flex flex-col gap-2">
                        <div v-for="incident in incidents.slice(0, 3)" :key="incident.incident_id">
                            <Label :size="'lg'" :type="'link'" :incident="incident" class="w-[632px]" />
                        </div>
                    </div>
                </div>
                <div class="w-fit self-end text-lg flex items-center gap-3">
                    <p>{{ $t('frontpage.updates.more') }}</p>
                    <Icon src="ArrowRight" size="xl" color="text-homeblue-300" />
                </div>
            </nuxt-link>
            <nuxt-link to="/services"
                class="bg-home-grape text-home-grape-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            <Icon src="Graph" size="3xl" color="text-home-grape-300" />
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">{{ $t('services') }}</h2>
                    </div>
                    <p class="text-xl">{{ $t('frontpage.services.text') }}</p>
                </div>
                <div class="w-fit self-end text-lg flex items-center gap-3">
                    <p>{{ $t('frontpage.services.more') }}</p>
                    <Icon src="ArrowRight" size="xl" color="text-home-grape-300" />
                </div>
            </nuxt-link>
            <nuxt-link to="/countries"
                class="bg-home-kiwi text-home-kiwi-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            <Icon src="GlobeHemisphereWest" size="3xl" color="text-home-kiwi-300" />
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">{{ $t('countries') }}</h2>
                    </div>
                    <p class="text-xl">{{ $t('frontpage.countries.text') }}</p>
                </div>
                <div class="w-fit self-end text-lg flex items-center gap-3">
                    <p>{{ $t('frontpage.countries.more') }}</p>
                    <Icon src="ArrowRight" size="xl" color="text-home-kiwi-300" />
                </div>
            </nuxt-link>
            <nuxt-link to="/carriers"
                class="bg-home-tangerine text-home-tangerine-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            <Icon src="Truck" size="3xl" color="text-home-tangerine-300" />
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">{{ $t('carriers') }}</h2>
                    </div>
                    <p class="text-xl">{{ $t('frontpage.carriers.text') }}</p>
                </div>
                <div class="w-fit self-end text-lg flex items-center gap-3">
                    <p>{{ $t('frontpage.carriers.more') }}</p>
                    <Icon src="ArrowRight" size="xl" color="text-home-tangerine-300" />
                </div>
            </nuxt-link>
            <nuxt-link to="/deadlines-and-peak"
                class="bg-home-raspberry text-home-raspberry-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            <Icon src="Calendar" size="3xl" color="text-home-raspberry-300" />
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">{{ $t('deadlines_and_peak') }}</h2>
                    </div>
                    <p class="text-xl">{{ $t('frontpage.deadlines_and_peak.text') }}</p>
                </div>
                <div class="w-fit self-end text-lg flex items-center gap-3">
                    <p>{{ $t('frontpage.deadlines_and_peak.more') }}</p>
                    <Icon src="ArrowRight" size="xl" color="text-home-raspberry-300" />
                </div>
            </nuxt-link>
            <div class="col-span-2 md:col-span-3">
                <Banner class="flex flex-col gap-6">
                    <div class="fields text-[64px] text-homeblue-100">{{ $t('banner_text') }}</div>
                    <Button text="Subscribe" />
                </Banner>
            </div>
        </section>
    </div>
</template>

<script setup lang="ts">
import { onMounted, computed } from 'vue';
import { useIncidents } from '~/composables/useIncidents';
import { useI18n } from 'vue-i18n';
const { locale } = useI18n();
const { incidents, fetchIncidents } = useIncidents();

onMounted(() => {
    fetchIncidents();
    //throw createError({ statusCode: 405, message: 'Method Not Allowed' });
});

watch(locale, () => {
  fetchIncidents();
});

</script>