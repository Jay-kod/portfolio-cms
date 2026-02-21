<template>
  <AdminLayout :title="title" :subtitle="subtitle" :heroGradient="heroGradient">
    <template #hero-icon>
      <slot name="hero-icon">
        <span class="text-2xl select-none">📋</span>
      </slot>
    </template>
    <template #hero-actions>
      <button @click="$emit('create')"
              class="inline-flex items-center gap-2 backdrop-blur-sm px-5 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-lg"
              :style="{ background: 'var(--accent, #00ff88)', color: '#000', boxShadow: '0 4px 14px ' + 'var(--accent, #00ff88)' + '30' }">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Add {{ singularTitle }}
      </button>
    </template>

    <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary, #111111); border: 1px solid var(--border-color, #1f1f1f);">
      <div v-if="items.length === 0" class="text-center py-20" style="color: var(--text-secondary, #6b7280);">
        <span class="text-4xl block mb-4 select-none">📭</span>
        <p class="font-semibold text-lg" style="color: var(--text-primary, #ffffff);">No {{ title.toLowerCase() }} yet</p>
        <p class="text-sm mt-1" style="color: var(--text-secondary, #6b7280);">Click "Add {{ singularTitle }}" to get started.</p>
      </div>
      <slot v-else :items="items" />
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';

defineProps({
  title: String,
  singularTitle: String,
  subtitle: { type: String, default: '' },
  heroGradient: { type: String, default: '' },
  items: { type: Array, default: () => [] },
});

defineEmits(['create']);
</script>
