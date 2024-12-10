<template>
    <footer class="max-w-[1096px] mx-3 lg:mx-auto">
        <div class="grid grid-cols-1 sm:grid-cols-2 border-y border-text-homegrey py-10 gap-10 md:gap-0">
            <img class="h-6 ml-1" :src="'https://a.storyblok.com/f/264288/272x38/87d27f74ef/homerunner_logo-1.png'"
                alt="homerunner_logo">
            <div v-for="(footer, index) in footerLinks" :key="footer.title" class="mb-6">
                <p class="text-lg font-bold mb-2">{{ footer.title }}</p>
                <ul>
                    <li v-for="link in footer.links" :key="link.text" class="mb-2">
                        <template v-if="link.url">
                            <a :href="link.url" target="_blank" rel="noopener noreferrer"
                                class="text-blue-500 hover:underline">
                                {{ link.text }}
                            </a>
                        </template>
                        <template v-else>
                            <span class="text-gray-700">{{ link.text }}</span>
                        </template>
                    </li>
                </ul>
            <!-- <div v-for="footerlink in storyContent.footer_links" :key="footerlink._uid">
            <p class="text-[18px] font-bold mb-4">{{ footerlink.title }}</p>
            <div v-for="link in footerlink.links" :key="link._uid">
              <div class="cursor-pointer mb-4 text-text-lightgrey"
                v-if="link.link.linktype == 'story' && link.link.cached_url"
                @click="navigateTo({ path: link.link.cached_url })">{{ link.text }}</div>
              <div class="cursor-pointer mb-4 text-text-lightgrey" v-if="link.link.linktype == 'url'"> <a
                  :href="link.link.cached_url" target="_blank" rel="noopener noreferrer">{{ link.text }}</a></div>
              <div class="mb-4 text-text-lightgrey" v-if="!link.link.cached_url && link.link.linktype == 'story'">{{
                link.text }}</div>
            </div>
          </div> -->
        </div>
        </div>
        <p class="py-10">© Homerunner 2023</p>
    </footer>

</template>

<script>
export default {
    data() {
        return {
            footerLinks: [
                {
                    title: "Produkt",
                    links: [
                        { text: "Løsning", url: "https://www.homerunner.com/solution" },
                        { text: "Features", url: "https://homerunner.com/features" },
                        { text: "Integrationer", url: "https://www.homerunner.com/integrations/" },
                    ],
                },
                {
                    title: "Ressourcer",
                    links: [
                        { text: "Cases", url: "https://www.homerunner.com/cases" },
                        { text: "Blog", url: "https://www.homerunner.com/blog" },
                        { text: "Kontakt", url: "https://www.homerunner.com/contact" },
                    ],
                },
                {
                    title: "Homerunner",
                    links: [
                        { text: "Om os", url: "https://www.homerunner.com/about" },
                        { text: "Østerågade 27, 9000 Aalborg" },
                        { text: "CVR: 36721146" },
                    ]
                },
            ],
        };
    },
};
</script>

<style></style>