<template>
    <div class="fixed top-0 w-full z-50 navbar px-4 md:px-0" :class="{ 'navbar--hidden': !showNavbar }">
        <header
            class="flex relative items-center justify-between bg-white rounded-full shadow-home p-3 mt-8 max-w-content mx-auto z-50">
            <div>
                <nuxt-link to="/">
                    <img src="/images/homerunner-logo.png" alt="Homerunner Logo" class="h-6">
                </nuxt-link>
            </div>
            <nav class="hidden md:flex py-2 items-start gap-6">
                <nuxt-link to="/updates">
                    <p class="-tracking-[.16px] leading-[110%] font-medium">
                        {{ $t('incidents') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/services">
                    <p class="-tracking-[.16px] leading-[110%] font-medium">
                        {{ $t('services') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/countries">
                    <p class="-tracking-[.16px] leading-[110%] font-medium">
                        {{ $t('countries') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/carriers">
                    <p class="-tracking-[.16px] leading-[110%] font-medium">
                        {{ $t('carriers') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/deadlines-and-peak">
                    <p class="-tracking-[.16px] leading-[110%] font-medium">
                        {{ $t('deadlines_and_peak') }}
                    </p>
                </nuxt-link>
            </nav>
            <form class="flex items-center gap-1">
                <label for="locale-select">
                    <Icon src="Globe" size="2xl" color="text-text-primary" />
                </label>
                <select id="locale-select" v-model="$i18n.locale" @change="saveLanguage($i18n.locale)">
                    <option value="da">DA</option>
                    <option value="en">EN</option>
                </select>
            </form>

            <div class="hidden md:flex items-center gap-6">
                <nuxt-link to="/admin">
                    <p
                        class="bg-homeblue-100 text-center text-white rounded-full border border-homeblue-120 px-4 py-[10px] -tracking-[.16px] leading-[110%] hover:bg-white hover:text-homeblue-120 transition duration-300 cursor-pointer">
                        {{ $t('go_to_admin') }}
                    </p>
                </nuxt-link>
            </div>
            <div class="ml-auto block md:hidden cursor-pointer relative" @click="showMobileNav()">
                <svg class="ham hamRotate ham8" viewBox="0 0 100 100" width="50"
                    :class="mobiledNavShown ? 'active' : ''">
                    <path class="line top"
                        d="m 30,33 h 40 c 3.722839,0 7.5,3.126468 7.5,8.578427 0,5.451959 -2.727029,8.421573 -7.5,8.421573 h -20" />
                    <path class="line middle" d="m 30,50 h 40" />
                    <path class="line bottom"
                        d="m 70,67 h -40 c 0,0 -7.5,-0.802118 -7.5,-8.365747 0,-7.563629 7.5,-8.634253 7.5,-8.634253 h 20" />
                </svg>
            </div>
            <nav class="w-full overflow-hidden max-h-0 transition-all duration-300 bg-white absolute top-14 right-0 rounded-b-[35px]"
                :class="mobiledNavShown ? 'max-h-[550px] py-10' : 'max-h-0'">
                <nuxt-link to="/updates">
                    <p class="text-2xl cursor-pointer mb-6 -tracking-[.16px] leading-[110%] font-medium text-center">
                        {{ $t('incidents') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/services">
                    <p class="text-2xl cursor-pointer mb-6 -tracking-[.16px] leading-[110%] font-medium text-center">
                        {{ $t('services') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/countries">
                    <p class="text-2xl cursor-pointer mb-6 -tracking-[.16px] leading-[110%] font-medium text-center">
                        {{ $t('countries') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/carriers">
                    <p class="text-2xl cursor-pointer mb-6 -tracking-[.16px] leading-[110%] font-medium text-center">
                        {{ $t('carriers') }}
                    </p>
                </nuxt-link>
                <nuxt-link to="/deadlines-and-peak">
                    <p class="text-2xl cursor-pointer mb-6 -tracking-[.16px] leading-[110%] font-medium text-center">
                        {{ $t('deadlines_and_peak') }}
                    </p>
                </nuxt-link>
                <div>
                    <nuxt-link to="/admin">

                        <p
                            class="bg-homeblue-100 text-white rounded-full border border-homeblue-500 px-4 py-[10px] -tracking-[.16px] leading-[110%] font-medium hover:bg-white hover:text-homeblue-500 transition duration-300 cursor-pointer max-w-max mx-auto">
                            {{ $t('go_to_admin') }}
                        </p>
                    </nuxt-link>
                </div>
            </nav>
            <div class="w-5 bg-white absolute top-11 left-0" :class="mobiledNavShown ? 'h-5' : 'h-0'"></div>
            <div class="w-5 bg-white absolute top-11 right-0" :class="mobiledNavShown ? 'h-5' : 'h-0'"></div>
        </header>
    </div>
</template>

<script setup>
const router = useRouter();

const showNavbar = ref(true);
const lastScrollPosition = ref(0);
const mobiledNavShown = ref(false);

const saveLanguage = (lang) => {
  localStorage.setItem('user-lang', lang);
};

const showMobileNav = () => {
    mobiledNavShown.value = !mobiledNavShown.value;
};

const goToPage = (slug) => {
    if (slug.includes("/da/")) {
        slug = slug.replace("/da/", "");
    }
    if (slug.includes("/en/")) {
        slug = slug.replace("/en/", "");
    }
    showMobileNav();
    router.push("/" + slug);
};

const onScroll = () => {
    const currentScrollPosition = window.scrollY || document.documentElement.scrollTop;
    if (currentScrollPosition < 0) return;
    if (Math.abs(currentScrollPosition - lastScrollPosition.value) < 60) return;
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


<style>
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