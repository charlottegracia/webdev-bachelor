<template>
    <div class="shadow-sm fixed top-0 w-full z-50 navbar px-4 md:px-0 max-w-screen-xl mx-auto" :class="{ hidden: !showNavbar }">
      <div
        class="flex relative items-center justify-between bg-white rounded-full shadow-home p-3 h-16 mt-8 max-w-content mx-auto z-50">
        <div>
          <nuxt-link to="/">
            <div>logo</div>
          </nuxt-link>
        </div>
        <div class="ml-auto gap-6 hidden md:flex">
          
        </div>
      </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, onBeforeUnmount } from "vue";

const showNavbar = ref(true);
const lastScrollPosition = ref(0);

const onScroll = () => {
  const currentScrollPosition = window.scrollY || document.documentElement.scrollTop;
  if (currentScrollPosition < 0) {
    return;
  }
  if (Math.abs(currentScrollPosition - lastScrollPosition.value) < 60) {
    return;
  }
  showNavbar.value = currentScrollPosition < lastScrollPosition.value;
  lastScrollPosition.value = currentScrollPosition;
};

onMounted(() => {
  window.addEventListener("scroll", onScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener("scroll", onScroll);
});
</script>

<style scoped>
.navbar {
  position: fixed;
  animation: hidenavbar;
  animation-duration: 300ms;
  animation-fill-mode: forwards;
}

.navbar.navbar--hidden {
  animation: shownavbar;
  animation-duration: 300ms;
  animation-fill-mode: forwards;
}

@keyframes shownavbar {
  0% {
    transform: translate3d(0, 0, 0);
  }

  50% {
    transform: translate3d(0, 10%, 0);
  }

  100% {
    transform: translate3d(0, -101%, 0);
  }
}

@keyframes hidenavbar {
  0% {
    transform: translate3d(0, -101%, 0);
  }

  50% {
    transform: translate3d(0, 10%, 0);
  }

  100% {
    transform: translate3d(0, 0, 0);
  }
}

.ham {
  cursor: pointer;
  -webkit-tap-highlight-color: transparent;
  transition: transform 400ms;
  -moz-user-select: none;
  -webkit-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

.line {
  fill: none;
  transition: stroke-dasharray 400ms, stroke-dashoffset 400ms;
  stroke: #1b2f4d;
  stroke-width: 4;
  stroke-linecap: round;
}

.hamRotate.active {
  transform: rotate(45deg);
}

.ham8 .top {
  stroke-dasharray: 40 160;
}

.ham8 .middle {
  stroke-dasharray: 40 142;
  transform-origin: 50%;
  transition: transform 400ms;
}

.ham8 .bottom {
  stroke-dasharray: 40 85;
  transform-origin: 50%;
  transition: transform 400ms, stroke-dashoffset 400ms;
}

.ham8.active .top {
  stroke-dashoffset: -64px;
}

.ham8.active .middle {
  /*stroke-dashoffset: -20px;*/
  transform: rotate(90deg);
}

.ham8.active .bottom {
  stroke-dashoffset: -64px;
}
</style>
