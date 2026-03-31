<script setup>
import { computed } from 'vue'

const props = defineProps({
    question: Object,
    currentIndex: Number,
    total: Number,
    answers: Object,
    partnerPriorities: Array,
    isLast: Boolean,
    isExtended: Boolean,
    canProceed: Boolean,
})

const emit = defineEmits(['select', 'next', 'back'])

const isMultiSelect = computed(() => props.question?.select_count > 1)

const progressPercent = computed(() => {
    return ((props.currentIndex + 1) / props.total) * 100
})

function isSelected(index) {
    if (isMultiSelect.value) {
        return props.partnerPriorities.includes(index)
    }
    return props.answers[props.question.id] === index
}

function handleSelect(index) {
    emit('select', props.question.id, index)
}
</script>

<template>
    <div v-if="question" class="flex-1 flex flex-col">
        <!-- プログレスバー -->
        <div class="mb-5">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-400 font-medium">
                    {{ isExtended ? '追加質問' : '' }}
                </span>
                <span class="text-xs font-bold text-orange-400">
                    {{ currentIndex + 1 }} / {{ total }}
                </span>
            </div>
            <div class="h-1.5 bg-orange-100 rounded-full overflow-hidden">
                <div
                    class="h-full bg-gradient-to-r from-rose-400 to-orange-400 rounded-full transition-all duration-500"
                    :style="{ width: progressPercent + '%' }"
                ></div>
            </div>
        </div>

        <!-- 質問カード -->
        <div
            class="bg-white rounded-[20px] p-6 shadow-md flex-1 flex flex-col relative overflow-hidden animate-slide-up"
            :key="question.id"
        >
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-400 via-amber-400 to-green-400"></div>

            <div class="text-center mb-1">
                <span class="text-xs font-bold text-orange-400 tracking-widest">Q{{ currentIndex + 1 }}</span>
            </div>
            <h3 class="text-base font-bold text-center leading-relaxed mb-1 whitespace-pre-line">
                {{ question.text }}
            </h3>
            <p v-if="question.hint" class="text-[11px] text-gray-400 text-center mb-5">
                {{ question.hint }}
            </p>
            <div v-else class="mb-5"></div>

            <!-- 複数選択の注記 -->
            <p v-if="isMultiSelect" class="text-xs text-orange-400 text-center mb-3 font-semibold">
                {{ question.select_count }}つ選んでください
            </p>

            <!-- 選択肢 -->
            <div class="flex flex-col gap-2 flex-1">
                <button
                    v-for="(option, index) in question.options"
                    :key="index"
                    @click="handleSelect(index)"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 text-left transition-all text-sm font-medium"
                    :class="isSelected(index)
                        ? 'border-orange-400 bg-orange-50'
                        : 'border-transparent bg-gray-50 hover:border-orange-200 hover:bg-orange-50 hover:-translate-y-0.5'"
                >
                    <span
                        class="w-5 h-5 min-w-[20px] rounded-full border-2 flex items-center justify-center transition-all"
                        :class="isSelected(index)
                            ? 'bg-orange-400 border-orange-400 shadow-sm shadow-orange-200'
                            : 'border-gray-300 bg-white'"
                    >
                        <svg v-if="isSelected(index)" class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                    </span>
                    <span>{{ option }}</span>
                </button>
            </div>

            <!-- ナビゲーション -->
            <div class="flex gap-3 mt-5 pt-4 border-t border-gray-100">
                <button
                    @click="emit('back')"
                    :disabled="currentIndex === 0"
                    class="px-5 py-3 rounded-xl border-2 border-gray-200 bg-white text-gray-400 font-bold text-sm transition-all disabled:opacity-30"
                >
                    戻る
                </button>
                <button
                    @click="emit('next')"
                    :disabled="!canProceed"
                    class="flex-1 py-3 rounded-xl font-bold text-sm text-white transition-all"
                    :class="canProceed
                        ? 'bg-gradient-to-r from-rose-400 to-orange-400 shadow-md shadow-orange-200 hover:-translate-y-0.5'
                        : 'bg-gray-300 cursor-not-allowed'"
                >
                    {{ isLast ? '結果を見る' : '次へ' }}
                </button>
            </div>
        </div>
    </div>
</template>

<style scoped>
.animate-slide-up {
    animation: slideUp 0.35s ease;
}
@keyframes slideUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
