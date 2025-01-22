import { createI18n } from 'vue-i18n'
import en from '../locales/en.json'
import da from '../locales/da.json'
import { defineNuxtPlugin } from '#app';

export default defineNuxtPlugin(({ vueApp }) => {
  let userLang = 'en'; // Default fallback language

  // Use process.client to check for localStorage on the client-side
  if (process.client) {
    // Check if the user has a saved language preference
    const savedLang = localStorage.getItem('user-lang');

    if (savedLang) {
      userLang = savedLang; // Use saved language if available
    } else {
      // Fallback to browser language
      const browserLang = navigator.language || 'en'; // Default to 'en' if undefined
      userLang = browserLang.startsWith('da') ? 'da' : 'en';

      // Save the browser language to localStorage
      localStorage.setItem('user-lang', userLang);
    }
  }

  const i18n = createI18n({
    legacy: false, // Use Composition API style
    globalInjection: true, // Makes $i18n and $t available globally
    locale: userLang, // Use the determined locale
    messages: {
      en,
      da,
    },
    warnHtmlInMessage: 'off'
  });

  vueApp.use(i18n); // Add vue-i18n to the app
});
