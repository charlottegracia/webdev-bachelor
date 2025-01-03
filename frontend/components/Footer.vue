<template>
    <footer class="max-w-content mx-auto mt-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 border-y border-text-homegrey py-10 gap-10 md:gap-0">
            <img class="h-6 ml-1" :src="logoPath" alt="Homerunner Logo">
            <div class="md:mx-auto grid grid-cols-1 md:grid-cols-3 px-0 gap-4">
                <div v-for="(footer, index) in footerLinks" :key="footer.title" class="mb-6">
                    <p class="font-bold mb-4">{{ footer.title }}</p>
                    <ul>
                        <li v-for="link in footer.links" :key="link.text" class="mb-2">
                            <div class="cursor-pointer mb-4 text-text-lightgrey" v-if="link.url">
                                <a :href="link.url" target="_blank" rel="noopener noreferrer"
                                    class="mb-4 text-text-lightgrey">
                                    {{ link.text }}
                                </a>
                            </div>
                            <template v-else>
                                <span class="text-text-lightgrey">{{ link.text }}</span>
                            </template>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <p class="py-10">© Homerunner {{ currentYear }}</p>
    </footer>
</template>

<script setup>
import { ref } from 'vue';

const logoPath = ref('/images/homerunner-logo.png');
const currentYear = ref(new Date().getFullYear());
const footerLinks = ref([
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
        ],
    },
]);
</script>
