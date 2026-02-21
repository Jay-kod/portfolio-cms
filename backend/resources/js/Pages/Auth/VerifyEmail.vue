<template>
  <div class="min-h-screen relative flex items-center justify-center p-4 overflow-hidden" :style="{ background: tc.theme_bg_primary }">
    <!-- Animated background grid -->
    <div class="absolute inset-0 pointer-events-none" :style="{
      backgroundImage: `linear-gradient(${tc.theme_accent}12 1px, transparent 1px), linear-gradient(90deg, ${tc.theme_accent}12 1px, transparent 1px)`,
      backgroundSize: '80px 80px'
    }"></div>

    <!-- Ambient orbs -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full blur-[120px] animate-pulse pointer-events-none" :style="{ background: tc.theme_accent + '18' }"></div>

    <!-- Card -->
    <div class="relative w-full max-w-[420px]">
      <div class="absolute -inset-1 rounded-3xl blur-xl" :style="{ background: `linear-gradient(90deg, ${tc.theme_accent}20, ${tc.theme_accent}10, ${tc.theme_accent}20)` }"></div>

      <div class="relative backdrop-blur-2xl rounded-3xl border shadow-2xl overflow-hidden" :style="{ background: tc.theme_bg_secondary + 'dd', borderColor: tc.theme_border }">
        <div class="h-[2px]" :style="{ background: `linear-gradient(90deg, transparent, ${tc.theme_accent}, transparent)` }"></div>

        <!-- Header -->
        <div class="px-8 pt-10 pb-2 text-center">
          <div class="relative inline-flex mb-6">
            <div class="absolute inset-0 rounded-2xl blur-xl" :style="{ background: tc.theme_accent + '30' }"></div>
            <div class="relative w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-white/10"
                 :style="{ background: tc.theme_accent, boxShadow: `0 4px 20px ${tc.theme_accent}40` }">
              <svg class="w-7 h-7" style="color: #000;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
              </svg>
            </div>
          </div>
          <h1 class="text-[22px] font-extrabold tracking-tight mb-1" :style="{ color: tc.theme_text_primary }">Verify Your Email</h1>
          <p class="text-sm leading-relaxed" :style="{ color: tc.theme_text_secondary }">
            A verification link has been sent to your email address. Please check your inbox and click the link to verify.
          </p>
        </div>

        <div class="px-8 pt-6 pb-8">
          <!-- Success message -->
          <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 -translate-y-1" enter-to-class="opacity-100 translate-y-0">
            <div v-if="$page.props.flash?.success" class="bg-green-500/10 border border-green-500/20 text-green-400 text-sm px-4 py-3 rounded-xl flex items-center gap-2.5 mb-5">
              <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              {{ $page.props.flash.success }}
            </div>
          </transition>

          <form @submit.prevent="resend" class="space-y-5">
            <button type="submit" class="relative w-full group" :disabled="form.processing">
              <div class="absolute -inset-0.5 rounded-xl blur opacity-60 group-hover:opacity-100 transition-opacity" :style="{ background: tc.theme_accent }"></div>
              <div class="relative w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2.5 shadow-lg"
                   :style="{ background: tc.theme_accent, color: '#000' }">
                <span v-if="!form.processing" class="flex items-center gap-2">
                  Resend Verification Email
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </span>
                <span v-else class="flex items-center gap-2">
                  <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Sending...
                </span>
              </div>
            </button>
          </form>
        </div>

        <div class="px-8 py-4 flex items-center justify-between" :style="{ borderTop: `1px solid ${tc.theme_border}` }">
          <div class="flex items-center gap-2">
            <div class="w-1.5 h-1.5 rounded-full animate-pulse" :style="{ background: tc.theme_accent }"></div>
            <span class="text-[11px]" :style="{ color: tc.theme_text_secondary }">Secure connection</span>
          </div>
          <span class="text-[11px]" :style="{ color: tc.theme_text_secondary }">
            {{ $page.props.siteSettings?.site_name || 'jaykod.io' }}
          </span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const tc = computed(() => {
  const t = page.props.themeColors || {};
  return {
    theme_bg_primary: t.theme_bg_primary || '#0a0a0a',
    theme_bg_secondary: t.theme_bg_secondary || '#111111',
    theme_accent: t.theme_accent || '#00ff88',
    theme_text_primary: t.theme_text_primary || '#ffffff',
    theme_text_secondary: t.theme_text_secondary || '#6b7280',
    theme_border: t.theme_border || '#1f1f1f',
  };
});

const form = useForm({});

const resend = () => {
  form.post(route('admin.verification.resend'), {
    preserveScroll: true,
  });
};
</script>
