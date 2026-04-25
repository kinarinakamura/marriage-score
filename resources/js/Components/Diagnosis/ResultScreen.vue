<script setup>
import { ref, onMounted, computed } from 'vue'

const props = defineProps({
    result: Object,
    hensachi: Number,
})

const emit = defineEmits(['retry'])

const displayScore = ref(0)
const showContent = ref(false)

const isHighScore = computed(() => props.result?.is_high_score)

onMounted(() => {
    // 紙吹雪
    setTimeout(launchConfetti, 500)

    // カウントアップ
    setTimeout(() => {
        animateScore(props.hensachi)
    }, 600)

    // コンテンツ表示
    setTimeout(() => {
        showContent.value = true
    }, 1800)
})

function animateScore(target) {
    const duration = 1000
    const startTime = performance.now()

    function update(now) {
        const progress = Math.min((now - startTime) / duration, 1)
        const eased = 1 - Math.pow(1 - progress, 3)
        displayScore.value = Math.round(eased * target)
        if (progress < 1) requestAnimationFrame(update)
    }
    requestAnimationFrame(update)
}

function launchConfetti() {
    const colors = ['#FF6B8A', '#FFB347', '#7DDBB5', '#B8A9E8', '#FFE0E8', '#E0F7ED']
    const container = document.body

    for (let i = 0; i < 40; i++) {
        const el = document.createElement('div')
        el.style.cssText = `
            position: fixed; top: 0; z-index: 100; pointer-events: none;
            left: ${Math.random() * 100}vw;
            background: ${colors[Math.floor(Math.random() * colors.length)]};
            width: ${5 + Math.random() * 8}px;
            height: ${5 + Math.random() * 8}px;
            border-radius: ${Math.random() > 0.5 ? '50%' : '2px'};
            animation: confettiFall ${2.4 + Math.random() * 3}s ease-out both;
            animation-delay: ${Math.random() * 0.5}s;
        `
        container.appendChild(el)
        setTimeout(() => el.remove(), 7500)
    }
}

function shareX() {
    const text = `婚活偏差値 ${props.hensachi} でした！ あなたも診断してみて👉`
    const url = window.location.origin
    window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}&url=${encodeURIComponent(url)}`, '_blank')
}

function shareLINE() {
    const url = window.location.origin
    window.open(`https://social-plugins.line.me/lineit/share?url=${encodeURIComponent(url)}`, '_blank')
}
</script>

<template>
    <div class="flex-1 mt-4">
        <!-- スコアカード -->
        <div class="bg-white rounded-[20px] p-8 shadow-md text-center mb-4 relative overflow-hidden animate-hero">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-400 via-amber-400 to-green-400 via-purple-400"></div>

            <div class="text-sm font-bold text-gray-400 mb-3">あなたの婚活偏差値</div>

            <div class="relative inline-block mb-3">
                <!-- グロウ -->
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-40 h-40 rounded-full bg-pink-400/15 animate-glow"></div>
                <!-- 数字 -->
                <div class="text-[88px] font-black leading-none relative z-10 bg-gradient-to-r from-pink-400 to-amber-400 bg-clip-text text-transparent animate-score-pop">
                    {{ displayScore }}
                </div>
            </div>

            <!-- パーセンタイル（高スコア時のみ） -->
            <div
                v-if="isHighScore && result.percentile"
                class="text-sm font-bold text-pink-400 animate-fade-in-delay"
            >
                上位 {{ result.percentile }}% にランクイン <span class="material-icons align-middle" style="font-size:16px;">auto_awesome</span>
            </div>
        </div>

        <!-- コメントカード -->
        <transition name="card">
            <div v-if="showContent" class="bg-white rounded-[20px] p-5 shadow-md mb-4 relative overflow-hidden">
                <div
                    class="absolute top-0 left-0 right-0 h-1"
                    :class="isHighScore ? 'bg-gradient-to-r from-green-400 to-amber-400' : 'bg-gradient-to-r from-purple-400 to-green-400'"
                ></div>

                <div class="flex items-center gap-1.5 mb-3">
                    <span
                        class="text-sm font-bold"
                        :class="isHighScore ? 'text-emerald-500' : 'text-purple-500'"
                    >
                        {{ isHighScore ? 'あなたの強み' : 'あなたの伸びしろ' }}
                    </span>
                </div>
                <p class="text-sm leading-relaxed text-gray-600" v-html="result.comment"></p>
            </div>
        </transition>

        <!-- 相性タイプカード -->
        <transition name="card">
            <div v-if="showContent && result.match_type" class="bg-white rounded-[20px] p-5 shadow-md mb-4 relative overflow-hidden">
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-amber-400 to-pink-400"></div>

                <div class="flex items-center gap-1.5 mb-3">
                    <span class="text-sm font-bold text-amber-500">相性のいいタイプ</span>
                </div>
                <div class="text-sm text-gray-500 mb-1">
                    {{ result.match_type.label }}
                </div>
                <p class="text-sm leading-relaxed font-black text-gray-500">
                    {{ result.match_type.text }}
                </p>
            </div>
        </transition>

        <!-- シェア -->
        <transition name="card">
            <div v-if="showContent" class="text-center mb-4">
                <div class="text-xs text-gray-400 font-medium mb-3">結果をシェアする</div>
                <div class="flex gap-3 justify-center">
                    <button
                        @click="shareX"
                        class="px-6 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-bold text-gray-500 transition-all hover:border-black hover:bg-gray-100"
                    >
                        𝕏 でシェア
                    </button>
                    <button
                        @click="shareLINE"
                        class="px-6 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-bold text-green-500 transition-all hover:border-green-300 hover:bg-green-50"
                    >
                        LINE に送る
                    </button>
                </div>
            </div>
        </transition>

        <!-- もう一度 -->
        <transition name="card">
            <div v-if="showContent" class="text-center">
                <button
                    @click="emit('retry')"
                    class="px-7 py-3 rounded-xl border-2 border-gray-200 bg-white text-sm font-bold text-gray-400 transition-all hover:bg-gray-50"
                >
                    もう一度やる
                </button>
            </div>
        </transition>
    </div>

    <!-- もう一度祝う（固定ボタン） -->
    <button
        @click="launchConfetti"
        class="fixed bottom-5 right-5 w-12 h-12 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 text-xl shadow-md transition-all hover:bg-white/10 hover:scale-125 z-50"
        title="もう一度祝う"
    ><span class="material-icons text-gray-400" style="font-size:22px;">celebration</span></button>
</template>

<style scoped>
.animate-hero {
    animation: heroReveal 0.7s ease 0.3s both;
}
@keyframes heroReveal {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-score-pop {
    animation: scorePop 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) 0.6s both;
}
@keyframes scorePop {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.animate-glow {
    animation: glowIn 1.5s ease 1s both;
}
@keyframes glowIn {
    0% { opacity: 0; transform: translate(-50%, -50%) scale(0.5); }
    60% { opacity: 1; }
    100% { opacity: 0.7; transform: translate(-50%, -50%) scale(1.1); }
}

.animate-fade-in-delay {
    animation: fadeIn 0.5s ease 1.4s both;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

.card-enter-active { animation: cardUp 0.5s ease; }
@keyframes cardUp {
    from { opacity: 0; transform: translateY(14px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<style>
@keyframes confettiFall {
    0% { transform: translateY(-100vh) rotate(0deg); opacity: 1; }
    80% { opacity: 1; }
    100% { transform: translateY(100vh) rotate(720deg); opacity: 0; }
}
</style>
