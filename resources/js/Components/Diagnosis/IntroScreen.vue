<script setup>
import { ref } from 'vue'

const emit = defineEmits(['start'])
const selectedGender = ref(null)

function selectGender(g) {
    selectedGender.value = g
}

function start() {
    if (selectedGender.value) {
        emit('start', selectedGender.value)
    }
}
</script>

<template>
    <div class="flex-1 flex flex-col justify-center animate-fade-in">
        <div class="bg-white rounded-[20px] p-8 shadow-md relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-pink-400 via-amber-400 to-green-400"></div>

            <div class="text-center">
                 <h2 class="text-xl font-black leading-relaxed mb-3 text-gray-600">
                    あなたの<span class="">婚活力</span>、<br>どのくらい？
                </h2>
                <p class="text-sm text-gray-400 leading-relaxed mb-6">
                    簡単な質問に答えるだけで<br>
                    あなたの強みと相性のいいタイプがわかります
                </p>

                <div class="flex gap-2 justify-center mb-6">
                    <span class="bg-orange-50 border border-orange-200 rounded-lg px-3 py-2 text-xs font-bold text-gray-500">⏱ 約1分</span>
                    <span class="bg-orange-50 border border-orange-200 rounded-lg px-3 py-2 text-xs font-bold text-gray-500 flex items-center gap-1"><span class="material-icons" style="font-size:14px;">bar_chart</span> 7問でわかる</span>
                    <span class="bg-orange-50 border border-orange-200 rounded-lg px-3 py-2 text-xs font-bold text-gray-500 flex items-center gap-1"><span class="material-icons" style="font-size:14px;">lock</span> 登録不要</span>
                </div>

                <div class="h-px bg-gray-100 -mx-8 mb-5"></div>

                <div class="text-xs font-semibold text-gray-500 mb-3">性別を選んでください</div>
                <div class="flex gap-3 mb-5">
                    <button
                        @click="selectGender('female')"
                        class="flex-1 py-3 rounded-lg border-2 font-bold text-sm transition-all"
                        :class="selectedGender === 'female'
                            ? 'border-orange-400 bg-orange-50 text-orange-500'
                            : 'border-gray-200 bg-white text-gray-400 hover:border-orange-200'"
                    >
                        女性
                    </button>
                    <button
                        @click="selectGender('male')"
                        class="flex-1 py-3 rounded-lg border-2 font-bold text-sm transition-all"
                        :class="selectedGender === 'male'
                            ? 'border-orange-400 bg-orange-50 text-orange-500'
                            : 'border-gray-200 bg-white text-gray-400 hover:border-orange-200'"
                    >
                        男性
                    </button>
                </div>

                <button
                    @click="start"
                    :disabled="!selectedGender"
                    class="w-full py-4 rounded-lg font-bold text-base text-white transition-all"
                    :class="selectedGender
                        ? 'bg-gradient-to-r from-rose-400 to-orange-400 shadow-lg shadow-orange-200 hover:-translate-y-0.5'
                        : 'bg-gray-200 text-gray-400 cursor-not-allowed'"
                >
                    診断をはじめる →
                </button>
            </div>
        </div>
    </div>
</template>
