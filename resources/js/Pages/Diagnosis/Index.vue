<script setup>
import { ref, computed } from 'vue'
import { usePage, router } from '@inertiajs/vue3'
import axios from 'axios'
import IntroScreen from '@/Components/Diagnosis/IntroScreen.vue'
import QuestionScreen from '@/Components/Diagnosis/QuestionScreen.vue'
import BranchScreen from '@/Components/Diagnosis/BranchScreen.vue'
import ResultScreen from '@/Components/Diagnosis/ResultScreen.vue'

const { props } = usePage()
const allQuestions = props.questions

// State
const screen = ref('intro') // intro, quiz, branch, extended, result
const gender = ref(null)
const currentIndex = ref(0)
const answers = ref({})
const result = ref(null)
const isExtended = ref(false)
const isCalculating = ref(false)
const isMenuOpen = ref(false)

function toggleMenu() {
    isMenuOpen.value = !isMenuOpen.value
}

function closeMenu() {
    isMenuOpen.value = false
}

// 性別に応じた質問をフィルタリング
const basicQuestions = computed(() => {
    return allQuestions.filter(q => {
        if (q.category !== 'basic') return false
        if (q.type === 'common') return true
        return q.type === gender.value
    })
})

const extendedQuestions = computed(() => {
    return allQuestions.filter(q => {
        if (q.category !== 'extended') return false
        if (q.type === 'common') return true
        return q.type === gender.value
    })
})

const currentQuestions = computed(() => {
    if (screen.value === 'extended') return extendedQuestions.value
    return basicQuestions.value
})

const currentQuestion = computed(() => {
    return currentQuestions.value[currentIndex.value] || null
})

const totalQuestions = computed(() => currentQuestions.value.length)

// Actions
function startQuiz(selectedGender) {
    gender.value = selectedGender
    currentIndex.value = 0
    screen.value = 'quiz'
}

function selectOption(questionId, selectedIndex) {
    answers.value[questionId] = selectedIndex
}

function canProceed() {
    const q = currentQuestion.value
    if (!q) return false
    return answers.value[q.id] !== undefined
}

function goNext() {
    if (!canProceed()) return
    if (currentIndex.value < totalQuestions.value - 1) {
        currentIndex.value++
    } else if (screen.value === 'quiz') {
        screen.value = 'branch'
    } else if (screen.value === 'extended') {
        submitDiagnosis(true)
    }
}

function goBack() {
    if (currentIndex.value > 0) {
        currentIndex.value--
    }
}

function chooseBranch(extended) {
    if (extended) {
        isExtended.value = true
        currentIndex.value = 0
        screen.value = 'extended'
    } else {
        submitDiagnosis(false)
    }
}

async function submitDiagnosis(extended) {
    isCalculating.value = true
    try {
        const response = await axios.post('/api/diagnosis/calculate', {
            gender: gender.value,
            answers: answers.value,
            is_extended: extended,
        })
        result.value = response.data
        screen.value = 'result'
    } catch (error) {
        console.error('計算エラー:', error)
        alert('計算中にエラーが発生しました。もう一度お試しください。')
    } finally {
        isCalculating.value = false
    }
}

function retry() {
    screen.value = 'intro'
    gender.value = null
    currentIndex.value = 0
    answers.value = {}
    result.value = null
    isExtended.value = false
    window.scrollTo(0, 0)
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
                    <!-- button
                        class="w-full text-left px-4 py-3 rounded-xl text-sm font-medium hover:bg-gray-50 transition-colors"
                        style="color: #4A3D3D; opacity: 0.8;"
                        @click="() => { retry(); closeMenu() }"
                    >
                        運営者について
                    </button -->
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
            <IntroScreen
                v-if="screen === 'intro'"
                @start="startQuiz"
            />

            <QuestionScreen
                v-if="screen === 'quiz' || screen === 'extended'"
                :question="currentQuestion"
                :current-index="currentIndex"
                :total="totalQuestions"
                :answers="answers"
                :partner-priorities="partnerPriorities"
                :is-last="currentIndex === totalQuestions - 1"
                :is-extended="screen === 'extended'"
                :can-proceed="canProceed()"
                @select="selectOption"
                @next="goNext"
                @back="goBack"
            />

            <BranchScreen
                v-if="screen === 'branch'"
                :is-calculating="isCalculating"
                @choose="chooseBranch"
            />

            <ResultScreen
                v-if="screen === 'result'"
                :result="result"
                :hensachi="result?.hensachi"
                @retry="retry"
            />

            <!-- フッター -->
            <template v-if="screen === 'intro' || screen === 'result'">
                <footer class="text-center pt-6 pb-4 mt-auto">
                    <div class="bg-white rounded-2xl p-5 shadow-sm">
                        <div v-if="screen === 'intro'">
                            <div class="text-[10px] text-gray-400">運営者について</div>
                            <div class="text-sm font-bold mt-1">KU. 👩</div>
                            <div class="text-xs text-gray-400 mt-1 leading-relaxed">
                                都内のIT企業で働くエンジニアです。<br>開発経験を活かして、女性向けの婚活偏差値診断サイトを作りました。気軽に楽しんでいただけたら嬉しいです！
                            </div>
                        </div>
                        <div v-if="screen === 'result'" class="text-[10px] text-gray-400 leading-relaxed">
                            ※ 診断の配点はIBJ成婚白書（2024年度版）・国税庁 民間給与実態統計調査を参考にしています
                        </div>
                    </div>
                </footer>
            </template>
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

/* オーバーレイ */
.fade-enter-active, .fade-leave-active { transition: opacity 0.25s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }

/* ドロワー */
.slide-enter-active, .slide-leave-active { transition: transform 0.3s ease; }
.slide-enter-from, .slide-leave-to { transform: translateX(100%); }
</style>
