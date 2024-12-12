<template>
    <div>
        <h1 class="fields text-[64px] pb-12">Driftstatus</h1>
        <section class="grid grid-cols-2 md:grid-cols-3 gap-7 w-full">
            <div
                class="bg-homeblue-08 text-homeblue-300 col-span-2 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            ikon
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">Liveopdateringer</h2>
                    </div>
                    <p class="text-xl">Se en samlet oversigt over alle hændelser</p>
                    <div class="flex flex-col gap-2">
                        <div>label</div>
                        <div>label</div>
                        <div>label</div>
                    </div>
                </div>
                <nuxt-link to="/updates" class="w-fit self-end text-lg flex items-center gap-3">
                    <p>Se flere</p>
                    <p>ikon</p>
                </nuxt-link>
            </div>
            <div
                class="bg-home-grape text-home-grape-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            ikon
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">IT-services</h2>
                    </div>
                    <p class="text-xl">Status for Homerunners services og API'er</p>
                </div>
                <nuxt-link to="/services" class="w-fit self-end text-lg flex items-center gap-3">
                    <p>Se status</p>
                    <p>ikon</p>
                </nuxt-link>
            </div>
            <div
                class="bg-home-kiwi text-home-kiwi-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            ikon
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">Lande</h2>
                    </div>
                    <p class="text-xl">Geografiske hændelser, som kan skabe problemer for fragten i det givne land. Se detaljer på kortet
                    </p>
                </div>
                <nuxt-link to="/countries" class="w-fit self-end text-lg flex items-center gap-3">
                    <p>Åben kort</p>
                    <p>ikon</p>
                </nuxt-link>
            </div>
            <div
                class="bg-home-tangerine text-home-tangerine-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            ikon
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">Transportører</h2>
                    </div>
                    <p class="text-xl">Status på de forskellige transportører
                    </p>
                </div>
                <nuxt-link to="/carriers" class="w-fit self-end text-lg flex items-center gap-3">
                    <p>Se status</p>
                    <p>ikon</p>
                </nuxt-link>
            </div>
            <div
                class="bg-home-raspberry text-home-raspberry-300 col-span-1 h-[400px] rounded-2xl p-8 flex flex-col justify-between">
                <div class="flex flex-col gap-5">
                    <div class="flex items-center gap-5">
                        <div class="h-[50px] w-[50px] bg-home-mocca-25 rounded-2xl flex items-center justify-center">
                            ikon
                        </div>
                        <h2 class="fields text-xl md:text-[32px]">Datoer og tillæg</h2>
                    </div>
                    <p class="text-xl">Vigtige deadlines og peaktillæg
                    </p>
                </div>
                <nuxt-link to="/deadlines-and-peaks" class="w-fit self-end text-lg flex items-center gap-3">
                    <p>Se oversigt</p>
                    <p>ikon</p>
                </nuxt-link>
            </div>
            <div class="col-span-2 md:col-span-3">
                <Banner>
                    <div class="fields text-[64px] text-homeblue-100">Hold dig opdateret</div>
                </Banner>
            </div>
        </section>
    </div>
</template>