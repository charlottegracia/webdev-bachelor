<template>
  <button class="bg-homeblue-100 text-white border border-homeblue-100 px-9 py-[10px] h-12 -tracking-[.16px] leading-[110%] font-medium hover:bg-white hover:text-homeblue-100 transition duration-300 cursor-pointer max-w-max rounded-full">
    {{ text }}
  </button>
</template>

<script setup>
defineProps({
  text: {
    type: String,
    required: true
  }
});
</script>