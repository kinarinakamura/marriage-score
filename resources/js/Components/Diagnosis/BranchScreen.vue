<script setup>
defineProps({
    isCalculating: Boolean,
})

const emit = defineEmits(['choose'])
</script>

<template>
    <div class="flex-1 flex flex-col justify-center animate-fade-in">
        <div class="bg-white rounded-[20px] p-8 shadow-md relative overflow-hidden">
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-purple-400 via-pink-400 to-amber-400"></div>

            <div class="text-center">
                <h2 class="text-lg text-gray-600 font-black mb-2">お疲れさまでした！</h2>
                <p class="text-sm text-gray-400 leading-relaxed mb-8">
                    このまま結果を見ることもできますが、<br>
                    <strong class="text-orange-500">あと4問</strong>答えるとより精密な結果が出ます
                </p>

                <div class="flex flex-col gap-3">
                    <button
                        @click="emit('choose', true)"
                        :disabled="isCalculating"
                        class="w-full py-4 rounded-xl font-bold text-sm text-white bg-gradient-to-r from-rose-400 to-orange-400 shadow-lg shadow-purple-200 transition-all hover:-translate-y-0.5 disabled:opacity-50"
                    >
                        <span class="material-icons align-middle" style="font-size:16px;">search</span> もっと詳しく診断する（+4問）
                    </button>
                    <button
                        @click="emit('choose', false)"
                        :disabled="isCalculating"
                        class="w-full py-4 rounded-xl font-bold text-sm border-2 border-gray-200 text-gray-400 transition-all hover:border-pink-200 disabled:opacity-50"
                    >
                        {{ isCalculating ? '計算中...' : '今すぐ結果を見る' }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
