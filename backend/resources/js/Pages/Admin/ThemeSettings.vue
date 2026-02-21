<template>
  <AdminLayout title="Theme Settings" subtitle="Customize the admin panel colors and appearance" heroGradient="bg-gradient-to-r from-[#0a0a0a] to-[#1a1a1a]">
    <template #hero-icon>
      <span class="text-2xl select-none">🎨</span>
    </template>

    <div class="max-w-4xl mx-auto">
      <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!-- Color Controls -->
        <div class="lg:col-span-3">
          <div class="rounded-2xl shadow-sm border overflow-hidden" :style="cardStyle">
            <!-- Header -->
            <div class="px-6 py-5 border-b" :style="{ borderColor: colors.theme_border, background: colors.theme_bg_tertiary + '80' }">
              <h2 class="text-lg font-bold" :style="{ color: colors.theme_text_primary }">Color Palette</h2>
              <p class="text-sm mt-0.5" :style="{ color: colors.theme_text_secondary }">Click any color swatch to change it. Changes apply across the entire admin panel.</p>
            </div>

            <div class="p-6 space-y-5">
              <div v-for="setting in form.settings" :key="setting.key" class="group">
                <div class="flex items-center justify-between mb-2">
                  <div>
                    <label class="text-sm font-semibold" :style="{ color: colors.theme_text_primary }">{{ setting.label }}</label>
                    <p class="text-xs mt-0.5" :style="{ color: colors.theme_text_secondary }">{{ getDescription(setting.key) }}</p>
                  </div>
                  <div class="flex items-center gap-3">
                    <span class="text-xs font-mono uppercase tracking-wide" :style="{ color: colors.theme_text_secondary }">{{ setting.value }}</span>
                  </div>
                </div>
                <div class="flex items-center gap-3">
                  <div class="relative">
                    <div class="w-10 h-10 rounded-xl border-2 cursor-pointer shadow-lg transition-transform hover:scale-110"
                         :style="{ backgroundColor: setting.value, borderColor: colors.theme_border }"
                         @click="$refs['picker_' + setting.key]?.[0]?.click()"></div>
                    <input :ref="'picker_' + setting.key" type="color" v-model="setting.value"
                           class="absolute inset-0 opacity-0 cursor-pointer w-full h-full">
                  </div>
                  <div class="flex-1 h-10 rounded-xl overflow-hidden border" :style="{ borderColor: colors.theme_border }">
                    <div class="w-full h-full" :style="{ background: `linear-gradient(90deg, ${setting.value}00, ${setting.value})` }"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Actions -->
            <div class="px-6 py-4 border-t flex items-center justify-between" :style="{ borderColor: colors.theme_border }">
              <button @click="resetTheme" :disabled="resetting"
                      class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium transition-all border"
                      :style="{ color: colors.theme_text_secondary, borderColor: colors.theme_border }"
                      @mouseenter="$event.target.style.color = colors.theme_accent"
                      @mouseleave="$event.target.style.color = colors.theme_text_secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                {{ resetting ? 'Resetting...' : 'Reset to Defaults' }}
              </button>
              <button @click="saveTheme" :disabled="saving"
                      class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg"
                      :style="{ backgroundColor: colors.theme_accent, color: '#000000' }">
                <svg v-if="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span>{{ saving ? 'Saving...' : 'Save Theme' }}</span>
              </button>
            </div>
          </div>

          <!-- Presets -->
          <div class="mt-6 rounded-2xl shadow-sm border overflow-hidden" :style="cardStyle">
            <div class="px-6 py-4 border-b" :style="{ borderColor: colors.theme_border }">
              <h3 class="text-sm font-bold" :style="{ color: colors.theme_text_primary }">Quick Presets</h3>
            </div>
            <div class="p-4 grid grid-cols-2 sm:grid-cols-4 gap-3">
              <button v-for="preset in presets" :key="preset.name" @click="applyPreset(preset)"
                      class="group relative rounded-xl overflow-hidden border transition-all hover:scale-[1.02]"
                      :style="{ borderColor: colors.theme_border }">
                <div class="h-16 flex">
                  <div class="flex-1" :style="{ background: preset.colors.theme_bg_primary }"></div>
                  <div class="flex-1" :style="{ background: preset.colors.theme_bg_secondary }"></div>
                  <div class="w-4" :style="{ background: preset.colors.theme_accent }"></div>
                </div>
                <div class="px-3 py-2" :style="{ background: colors.theme_bg_tertiary }">
                  <span class="text-xs font-semibold" :style="{ color: colors.theme_text_primary }">{{ preset.name }}</span>
                </div>
              </button>
            </div>
          </div>
        </div>

        <!-- Live Preview -->
        <div class="lg:col-span-2">
          <div class="sticky top-20">
            <div class="rounded-2xl shadow-sm border overflow-hidden" :style="cardStyle">
              <div class="px-6 py-4 border-b" :style="{ borderColor: colors.theme_border }">
                <h3 class="text-sm font-bold" :style="{ color: colors.theme_text_primary }">Live Preview</h3>
              </div>
              <div class="p-4">
                <!-- Mini sidebar preview -->
                <div class="rounded-xl overflow-hidden border" :style="{ borderColor: colors.theme_border }">
                  <div class="flex h-48">
                    <!-- Sidebar -->
                    <div class="w-14 flex flex-col items-center py-3 gap-2" :style="{ background: colors.theme_bg_secondary, borderRight: `1px solid ${colors.theme_border}` }">
                      <div class="w-7 h-7 rounded-lg flex items-center justify-center text-[10px] font-black" :style="{ background: colors.theme_accent, color: '#000' }">JK</div>
                      <div class="w-5 h-1 rounded-full mt-2" :style="{ background: colors.theme_text_secondary + '40' }"></div>
                      <div class="w-5 h-1 rounded-full" :style="{ background: colors.theme_accent + '60' }"></div>
                      <div class="w-5 h-1 rounded-full" :style="{ background: colors.theme_text_secondary + '40' }"></div>
                      <div class="w-5 h-1 rounded-full" :style="{ background: colors.theme_text_secondary + '40' }"></div>
                    </div>
                    <!-- Content -->
                    <div class="flex-1 flex flex-col" :style="{ background: colors.theme_bg_primary }">
                      <!-- Header -->
                      <div class="h-8 flex items-center px-3 border-b" :style="{ background: colors.theme_bg_secondary + '80', borderColor: colors.theme_border }">
                        <div class="flex gap-1">
                          <div class="w-1.5 h-1.5 rounded-full" :style="{ background: colors.theme_text_secondary }"></div>
                          <div class="w-1.5 h-1.5 rounded-full" :style="{ background: colors.theme_text_secondary }"></div>
                        </div>
                        <div class="ml-2 w-12 h-1.5 rounded-full" :style="{ background: colors.theme_text_primary + '30' }"></div>
                      </div>
                      <!-- Hero -->
                      <div class="h-12 flex items-end px-3 pb-1.5" :style="{ background: `linear-gradient(135deg, ${colors.theme_accent}25, ${colors.theme_bg_tertiary})` }">
                        <div class="flex items-center gap-2">
                          <div class="w-5 h-5 rounded-md" :style="{ background: colors.theme_accent + '30' }"></div>
                          <div class="w-16 h-2 rounded-full" :style="{ background: colors.theme_text_primary + '90' }"></div>
                        </div>
                      </div>
                      <!-- Cards -->
                      <div class="flex-1 p-2 flex gap-2">
                        <div class="flex-1 rounded-lg p-2" :style="{ background: colors.theme_bg_secondary, border: `1px solid ${colors.theme_border}` }">
                          <div class="w-full h-1.5 rounded-full mb-1.5" :style="{ background: colors.theme_text_primary + '20' }"></div>
                          <div class="w-3/4 h-1.5 rounded-full" :style="{ background: colors.theme_text_secondary + '30' }"></div>
                          <div class="mt-2 w-8 h-3 rounded" :style="{ background: colors.theme_accent + '30' }"></div>
                        </div>
                        <div class="flex-1 rounded-lg p-2" :style="{ background: colors.theme_bg_secondary, border: `1px solid ${colors.theme_border}` }">
                          <div class="w-full h-1.5 rounded-full mb-1.5" :style="{ background: colors.theme_text_primary + '20' }"></div>
                          <div class="w-2/3 h-1.5 rounded-full" :style="{ background: colors.theme_text_secondary + '30' }"></div>
                          <div class="mt-2 w-8 h-3 rounded" :style="{ background: colors.theme_accent + '30' }"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Color swatches -->
                <div class="mt-4 grid grid-cols-7 gap-1.5">
                  <div v-for="setting in form.settings" :key="setting.key"
                       class="aspect-square rounded-lg border shadow-sm"
                       :style="{ backgroundColor: setting.value, borderColor: colors.theme_border }"
                       :title="setting.label"></div>
                </div>

                <!-- Text preview -->
                <div class="mt-4 rounded-xl p-4 space-y-2" :style="{ background: colors.theme_bg_secondary, border: `1px solid ${colors.theme_border}` }">
                  <div class="text-sm font-bold" :style="{ color: colors.theme_text_primary }">Primary Text</div>
                  <div class="text-xs" :style="{ color: colors.theme_text_secondary }">Secondary text for descriptions</div>
                  <div class="text-xs font-semibold" :style="{ color: colors.theme_accent }">Accent colored link →</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { router } from '@inertiajs/vue3';
import { reactive, ref, computed } from 'vue';

const props = defineProps({
  themeSettings: Array,
});

const saving = ref(false);
const resetting = ref(false);

const form = reactive({
  settings: props.themeSettings.map(s => ({ ...s })),
});

const colors = computed(() => {
  const obj = {};
  form.settings.forEach(s => { obj[s.key] = s.value; });
  return obj;
});

const cardStyle = computed(() => ({
  background: colors.value.theme_bg_secondary,
  borderColor: colors.value.theme_border,
}));

const getDescription = (key) => {
  const descriptions = {
    theme_bg_primary: 'Main page background — the darkest layer',
    theme_bg_secondary: 'Cards, sidebar, and elevated surfaces',
    theme_bg_tertiary: 'Subtle backgrounds, hover states, and dividers',
    theme_accent: 'Buttons, links, active states, and highlights',
    theme_text_primary: 'Headings and primary content',
    theme_text_secondary: 'Descriptions, labels, and muted text',
    theme_border: 'Borders, dividers, and separators',
  };
  return descriptions[key] || '';
};

const presets = [
  {
    name: 'Neon Dark',
    colors: {
      theme_bg_primary: '#0a0a0a', theme_bg_secondary: '#111111', theme_bg_tertiary: '#1a1a1a',
      theme_accent: '#00ff88', theme_text_primary: '#ffffff', theme_text_secondary: '#6b7280', theme_border: '#1f1f1f',
    },
  },
  {
    name: 'Cyber Purple',
    colors: {
      theme_bg_primary: '#0d0b1a', theme_bg_secondary: '#13102a', theme_bg_tertiary: '#1a1635',
      theme_accent: '#a855f7', theme_text_primary: '#f1f0ff', theme_text_secondary: '#7c7a9a', theme_border: '#241f47',
    },
  },
  {
    name: 'Ocean Blue',
    colors: {
      theme_bg_primary: '#0a1628', theme_bg_secondary: '#0f1d32', theme_bg_tertiary: '#152540',
      theme_accent: '#38bdf8', theme_text_primary: '#e8f4fd', theme_text_secondary: '#64839e', theme_border: '#1c3350',
    },
  },
  {
    name: 'Ember Red',
    colors: {
      theme_bg_primary: '#120a0a', theme_bg_secondary: '#1a0e0e', theme_bg_tertiary: '#231414',
      theme_accent: '#f43f5e', theme_text_primary: '#fff1f2', theme_text_secondary: '#9a7c7c', theme_border: '#2d1b1b',
    },
  },
];

const applyPreset = (preset) => {
  form.settings.forEach(s => {
    if (preset.colors[s.key]) {
      s.value = preset.colors[s.key];
    }
  });
};

const saveTheme = () => {
  saving.value = true;
  router.put(route('admin.theme.update'), {
    settings: form.settings.map(s => ({ key: s.key, value: s.value })),
  }, {
    preserveScroll: true,
    onFinish: () => { saving.value = false; },
  });
};

const resetTheme = () => {
  resetting.value = true;
  router.post(route('admin.theme.reset'), {}, {
    preserveScroll: true,
    onFinish: () => {
      resetting.value = false;
      // Update form with defaults
      const defaults = presets[0].colors;
      form.settings.forEach(s => {
        if (defaults[s.key]) s.value = defaults[s.key];
      });
    },
  });
};
</script>
