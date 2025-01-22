import { createI18n } from 'vue-i18n'
import en from '../locales/en.json'
import da from '../locales/da.json'
import { defineNuxtPlugin } from '#app';

export default defineNuxtPlugin(({ vueApp }) => {
  let userLang = 'en'; // default fallback language

  if (import.meta.client) {
    const savedLang = localStorage.getItem('user-lang'); // check if user has chosen a language
    if (savedLang) {
      userLang = savedLang; // use chosen language if available
    } else {
      const browserLang = navigator.language || 'en'; // check browserlanguage - default to 'en' if undefined
      userLang = browserLang.startsWith('da') ? 'da' : 'en'; // set language to 'da' if danish, otherwise 'en'
    }
  }

  const i18n = createI18n({
    legacy: false, 
    globalInjection: true, 
    locale: userLang, 
    messages: {
      en,
      da,
    },
    warnHtmlInMessage: 'off'
  });
  vueApp.use(i18n);
});


