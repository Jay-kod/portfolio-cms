<template>
  <div class="min-h-screen relative flex items-center justify-center p-4 overflow-hidden" :style="{ background: tc.theme_bg_primary }">
    <!-- Animated background grid -->
    <div class="absolute inset-0 pointer-events-none" :style="{
      backgroundImage: `linear-gradient(${tc.theme_accent}12 1px, transparent 1px), linear-gradient(90deg, ${tc.theme_accent}12 1px, transparent 1px), linear-gradient(${tc.theme_accent}08 1px, transparent 1px), linear-gradient(90deg, ${tc.theme_accent}08 1px, transparent 1px)`,
      backgroundSize: '80px 80px, 80px 80px, 20px 20px, 20px 20px'
    }"></div>

    <!-- Ambient orbs -->
    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] rounded-full blur-[120px] animate-pulse pointer-events-none" :style="{ background: tc.theme_accent + '18' }"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[400px] h-[400px] rounded-full blur-[100px] animate-pulse pointer-events-none" style="animation-delay: 1s;" :style="{ background: tc.theme_accent + '10' }"></div>
    <div class="absolute top-[40%] right-[20%] w-[200px] h-[200px] rounded-full blur-[80px] pointer-events-none" :style="{ background: tc.theme_accent + '08' }"></div>

    <!-- Corner decorations -->
    <div class="absolute top-8 left-8 w-20 h-20 border-l-2 border-t-2 rounded-tl-lg hidden lg:block" :style="{ borderColor: tc.theme_accent + '20' }"></div>
    <div class="absolute bottom-8 right-8 w-20 h-20 border-r-2 border-b-2 rounded-br-lg hidden lg:block" :style="{ borderColor: tc.theme_accent + '20' }"></div>

    <!-- Login card -->
    <div class="relative w-full max-w-[420px]">
      <!-- Glow effect behind card -->
      <div class="absolute -inset-1 rounded-3xl blur-xl" :style="{ background: `linear-gradient(90deg, ${tc.theme_accent}20, ${tc.theme_accent}10, ${tc.theme_accent}20)` }"></div>

      <div class="relative backdrop-blur-2xl rounded-3xl border shadow-2xl overflow-hidden" :style="{ background: tc.theme_bg_secondary + 'dd', borderColor: tc.theme_border }">
        <!-- Top accent line -->
        <div class="h-[2px]" :style="{ background: `linear-gradient(90deg, transparent, ${tc.theme_accent}, transparent)` }"></div>

        <!-- Header -->
        <div class="px-8 pt-10 pb-2 text-center">
          <!-- Brand icon -->
          <div class="relative inline-flex mb-6">
            <div class="absolute inset-0 rounded-2xl blur-xl" :style="{ background: tc.theme_accent + '30' }"></div>
            <div class="relative w-16 h-16 rounded-2xl flex items-center justify-center shadow-lg ring-1 ring-white/10"
                 :style="{ background: tc.theme_accent, boxShadow: `0 4px 20px ${tc.theme_accent}40` }">
              <span class="font-black text-lg tracking-tight" style="color: #000;">{{ $page.props.siteSettings?.site_icon_letter || 'JK' }}</span>
            </div>
          </div>

          <h1 class="text-[22px] font-extrabold tracking-tight mb-1" :style="{ color: tc.theme_text_primary }">Welcome back</h1>
          <p class="text-sm" :style="{ color: tc.theme_text_secondary }">Sign in to your admin dashboard</p>
        </div>

        <!-- Form -->
        <div class="px-8 pt-6 pb-8">
          <form @submit.prevent="submitLogin" class="space-y-5">
            <!-- Error -->
            <transition enter-active-class="transition ease-out duration-200" enter-from-class="opacity-0 -translate-y-1" enter-to-class="opacity-100 translate-y-0">
              <div v-if="form.errors.email" class="bg-red-500/10 border border-red-500/20 text-red-400 text-sm px-4 py-3 rounded-xl flex items-center gap-2.5">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                {{ form.errors.email }}
              </div>
            </transition>

            <!-- Email -->
            <div class="space-y-2">
              <label class="flex items-center gap-2 text-sm font-medium" :style="{ color: tc.theme_text_primary }">
                <svg class="w-4 h-4" :style="{ color: tc.theme_text_secondary }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Email
              </label>
              <input type="email" v-model="form.email"
                     class="w-full px-4 py-3 rounded-xl border focus:outline-none focus:ring-2 transition-all text-sm"
                     :style="{ background: tc.theme_bg_tertiary, borderColor: tc.theme_border, color: tc.theme_text_primary, '--tw-ring-color': tc.theme_accent + '50' }"
                     placeholder="you@example.com" required>
            </div>

            <!-- Password -->
            <div class="space-y-2">
              <label class="flex items-center gap-2 text-sm font-medium" :style="{ color: tc.theme_text_primary }">
                <svg class="w-4 h-4" :style="{ color: tc.theme_text_secondary }" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                Password
              </label>
              <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" v-model="form.password"
                       class="w-full px-4 py-3 pr-11 rounded-xl border focus:outline-none focus:ring-2 transition-all text-sm"
                       :style="{ background: tc.theme_bg_tertiary, borderColor: tc.theme_border, color: tc.theme_text_primary }"
                       placeholder="••••••••" required>
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 transition p-1" :style="{ color: tc.theme_text_secondary }">
                  <svg v-if="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                  <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" /></svg>
                </button>
              </div>
            </div>

            <!-- Remember & Forgot -->
            <div class="flex items-center justify-between">
              <label class="flex items-center gap-2.5 cursor-pointer group">
                <div class="relative">
                  <input type="checkbox" v-model="form.remember" class="sr-only peer">
                  <div class="w-4 h-4 rounded-[5px] border transition-all flex items-center justify-center"
                       :style="{ borderColor: tc.theme_border, background: form.remember ? tc.theme_accent : tc.theme_bg_tertiary }">
                    <svg v-if="form.remember" class="w-2.5 h-2.5" style="color: #000;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                  </div>
                </div>
                <span class="text-xs transition select-none" :style="{ color: tc.theme_text_secondary }">Remember me</span>
              </label>
              <a :href="route('admin.forgot-password')" class="text-xs transition font-medium" :style="{ color: tc.theme_accent }">
                Forgot password?
              </a>
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="relative w-full group mt-2"
                    :disabled="form.processing">
              <div class="absolute -inset-0.5 rounded-xl blur opacity-60 group-hover:opacity-100 transition-opacity" :style="{ background: tc.theme_accent }"></div>
              <div class="relative w-full py-3.5 rounded-xl font-bold text-sm transition-all flex items-center justify-center gap-2.5 shadow-lg"
                   :style="{ background: tc.theme_accent, color: '#000' }">
                <span v-if="!form.processing" class="flex items-center gap-2">
                  Sign In
                  <svg class="w-4 h-4 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </span>
                <span v-else class="flex items-center gap-2">
                  <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                  </svg>
                  Authenticating...
                </span>
              </div>
            </button>
          </form>
        </div>

        <!-- Footer -->
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

      <!-- Tagline below card -->
      <p class="text-center text-xs mt-6 tracking-wide" :style="{ color: tc.theme_text_secondary }">
        {{ $page.props.siteSettings?.site_tagline || "Jay's digital playground" }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const showPassword = ref(false);
const page = usePage();

const tc = computed(() => {
  const t = page.props.themeColors || {};
  return {
    theme_bg_primary: t.theme_bg_primary || '#0a0a0a',
    theme_bg_secondary: t.theme_bg_secondary || '#111111',
    theme_bg_tertiary: t.theme_bg_tertiary || '#1a1a1a',
    theme_accent: t.theme_accent || '#00ff88',
    theme_text_primary: t.theme_text_primary || '#ffffff',
    theme_text_secondary: t.theme_text_secondary || '#6b7280',
    theme_border: t.theme_border || '#1f1f1f',
  };
});

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submitLogin = () => {
  form.post(route('admin.login.submit'), {
    onFinish: () => form.reset('password'),
  });
};
</script>
