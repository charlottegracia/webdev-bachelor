<template>
  <div class="bg-home-bg">
    <Header />
    <section class="max-w-content mx-auto pt-48 pb-20 flex flex-row-reverse justify-center items-center gap-20">
      <div class="flex flex-col gap-4">
        <div class="text-4xl fields flex gap-2">
          <p>{{ statusCode }}</p>
          <p> - </p>
          <p>{{ errorTitle }}</p>
        </div>
        <p class="text-base">{{ errorDescription }}</p>
        <nuxt-link to="/">
          <Button :text="t('back_to_home')" />
        </nuxt-link>
      </div>
      <img :src="errorIllustration" alt="Error illustration" class="my-5" />
    </section>
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { useI18n } from 'vue-i18n';

const { t } = useI18n();
const error = useError();

const statusCode = computed(() => error.value?.statusCode);

// dynamic error title based on the status code
const errorTitle = computed(() => {
switch (statusCode.value) {
  case 400:
    return t("errors.400.title");
  case 401:
    return t("errors.401.title");
  case 403:
    return t("errors.403.title");
  case 404:
    return t("errors.404.title");
  case 405:
    return t("errors.405.title");
  case 500:
    return t("errors.500.title");
  case 502:
    return t("errors.502.title");
  default:
    return error.value?.message;
}
});

// dynamic error description based on the status code
const errorDescription = computed(() => {
switch (statusCode.value) {
  case 400:
    return t("errors.400.description");
  case 401:
    return t("errors.401.description");
  case 403:
    return t("errors.403.description");
  case 404:
    return t("errors.404.description");
  case 405:
    return t("errors.405.description");
  case 500:
    return t("errors.500.description");
  case 502:
    return t("errors.502.description");
  default:
    return "";
}
});

// dynamic error illustration path based on the status code
const errorIllustration = computed(() => {
switch (statusCode.value) {
  case 400:
    return "/images/errors/nc-octopus.svg";
  case 401:
    return "/images/errors/oc-login.svg";
  case 403:
    return "/images/errors/oc-login.svg";
  case 404:
    return "/images/errors/nc-improve-search-experience.svg";
  case 405:
    return "/images/errors/nc-work-efficiently.svg";
  case 500:
    return "/images/errors/nc-turning-off-lamp.svg";
  case 502:
    return "/images/errors/nc-octopus.svg";
  default:
    return "/images/errors/nc-octopus.svg";
}
});

</script>
