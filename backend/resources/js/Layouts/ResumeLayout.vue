<template>
  <div class="min-h-screen bg-gradient-to-br from-slate-50 to-violet-50/30">
    <!-- Minimal header for resume pages -->
    <header class="bg-white border-b border-slate-200 sticky top-0 z-50">
      <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <Link :href="route('portfolio')" class="flex items-center gap-2 text-slate-600 hover:text-violet-600 transition group">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span class="text-sm font-medium">Back to Portfolio</span>
        </Link>
        <div class="flex items-center gap-2 text-sm text-slate-400">
          <div class="w-2 h-2 rounded-full" :class="stepColor"></div>
          <span v-if="step">Step {{ step }} of {{ totalSteps }}</span>
        </div>
      </div>
    </header>

    <main class="max-w-6xl mx-auto px-4 py-12">
      <slot />
    </main>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  step: { type: Number, default: null },
  totalSteps: { type: Number, default: 3 },
});

const stepColor = computed(() => {
  if (!props.step) return 'bg-slate-300';
  if (props.step === props.totalSteps) return 'bg-emerald-500';
  return 'bg-violet-500';
});
</script>
