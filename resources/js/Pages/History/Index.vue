<script setup>
import { ref } from 'vue'
import { usePage, router } from '@inertiajs/vue3'

const { props } = usePage()
const histories = props.histories

const isMenuOpen = ref(false)

function toggleMenu() {
    isMenuOpen.value = !isMenuOpen.value
}

function closeMenu() {
    isMenuOpen.value = false
}
</script>

<template>
    <div class="min-h-screen relative overflow-hidden" style="background: #FFF9F5">
        <!-- 浮遊シェイプ -->
        <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
            <div class="floating-shape shape-1"></div>
            <div class="floating-shape shape-2"></div>
            <div class="floating-shape shape-3"></div>
            <div class="floating-shape shape-4"></div>
            <div class="floating-shape shape-5"></div>
        </div>

        <!-- ハンバーガーメニュー オーバーレイ -->
        <Transition name="fade">
            <div
                v-if="isMenuOpen"
                class="fixed inset-0 bg-black/40 z-40"
                @click="closeMenu"
            />
        </Transition>

        <!-- ドロワー -->
        <Transition name="slide">
            <div
                v-if="isMenuOpen"
                class="fixed top-0 right-0 h-full w-72 bg-white z-50 shadow-2xl flex flex-col"
            >
                <div class="flex items-center justify-between px-5 py-5 border-b border-gray-100">
                    <div class="flex items-center gap-1">
                        <img src="/images/logo_ring.png" alt="logo" class="h-5" />
                        <span class="font-bold text-sm" style="color: #4A3D3D;">婚活偏差値診断</span>
                    </div>
                    <button class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-gray-100" @click="closeMenu">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <nav class="flex-1 px-4 py-6 space-y-2">
                    <button
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors"
                        style="color: #4A3D3D; opacity: 0.8;"
                        @click="() => { closeMenu(); router.visit('/history') }"
                    >
                        更新履歴
                    </button>
                </nav>
            </div>
        </Transition>

        <!-- ヘッダー（全幅） -->
        <header class="z-10 w-full px-5 md:px-10 py-4 flex items-center justify-between" style="background: #FFF9F5;">
            <div class="flex items-center gap-2">
                <img src="/images/logo_ring.png" alt="logo" class="h-7" />
                <h1 class="text-base font-black" style="color: #4A3D3D;">婚活偏差値診断</h1>
            </div>
            <button
                class="w-9 h-9 flex flex-col items-center justify-center gap-[5px] rounded-xl hover:bg-pink-50 transition-colors"
                @click="toggleMenu"
                aria-label="メニューを開く"
            >
                <span class="block w-5 h-0.5 rounded-full transition-all duration-300" :class="isMenuOpen ? 'rotate-45 translate-y-[7px]' : ''" style="background:#4A3D3D" />
                <span class="block w-5 h-0.5 rounded-full transition-all duration-300" :class="isMenuOpen ? 'opacity-0' : ''" style="background:#4A3D3D" />
                <span class="block w-5 h-0.5 rounded-full transition-all duration-300" :class="isMenuOpen ? '-rotate-45 -translate-y-[7px]' : ''" style="background:#4A3D3D" />
            </button>
        </header>

        <div class="max-w-[440px] mx-auto px-5 pb-5 relative z-10 flex flex-col">

            <!-- メインコンテンツ -->
            <div class="flex-1 flex flex-col justify-center animate-fade-in mt-4 mb-10">
                <div class="bg-white rounded-[20px] p-8 shadow-md relative overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-400 via-amber-400 to-green-400"></div>

                    <h2 class="text-lg font-black mb-6" style="color: #4A3D3D;">更新履歴</h2>

                    <ul class="space-y-4">
                        <li
                            v-for="(description, date) in histories"
                            :key="date"
                            class="flex gap-4 items-start"
                        >
                            <span class="text-xs font-semibold text-gray-400 whitespace-nowrap pt-0.5">{{ date }}</span>
                            <span class="text-sm text-gray-600 leading-relaxed">{{ description }}</span>
                        </li>
                    </ul>
                </div>

                <div class="mt-6 flex justify-center">
                    <button
                        @click="router.visit('/')"
                        class="w-1/2 py-3 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-rose-400 to-orange-400 shadow-lg shadow-orange-200 hover:-translate-y-0.5 transition-all"
                    >
                        診断に戻る
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.floating-shape {
    position: absolute;
    border-radius: 50%;
    animation: float 12s ease-in-out infinite;
}
.shape-1 { width: 240px; height: 240px; background: #FF6B8A; opacity: 0.12; top: -50px; right: -50px; }
.shape-2 { width: 160px; height: 160px; background: #FFB347; opacity: 0.10; bottom: 10%; left: -40px; animation-delay: 3s; }
.shape-3 { width: 100px; height: 100px; background: #7DDBB5; opacity: 0.12; top: 40%; right: -20px; animation-delay: 6s; }
.shape-4 { width: 130px; height: 130px; background: #B8A9E8; opacity: 0.10; top: 15%; left: -30px; animation-delay: 9s; }
.shape-5 { width: 80px; height: 80px; background: #FF6B8A; opacity: 0.08; bottom: 20%; right: 15%; animation-delay: 1.5s; }

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-16px); }
}

.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

.slide-enter-active, .slide-leave-active { transition: transform 0.3s ease; }
.slide-enter-from, .slide-leave-to { transform: translateX(100%); }
</style>
