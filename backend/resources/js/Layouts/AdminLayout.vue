<template>
  <div class="min-h-screen flex" :style="rootStyle">
    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-30 flex flex-col transition-all duration-300 ease-in-out"
           :class="[
             sidebarCollapsed ? 'w-[72px]' : 'w-[260px]',
             sidebarMobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
           ]"
           :style="{ background: tc.theme_bg_secondary, borderRight: `1px solid ${tc.theme_border}` }">
      <!-- Brand -->
      <div class="h-16 flex items-center overflow-hidden" :class="sidebarCollapsed ? 'px-0 justify-center' : 'px-5'"
           :style="{ borderBottom: `1px solid ${tc.theme_border}` }">
        <Link :href="route('portfolio')" class="flex items-center gap-3 flex-shrink-0">
          <div class="w-9 h-9 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0"
               :style="{ background: tc.theme_accent, boxShadow: `0 4px 14px ${tc.theme_accent}30` }">
            <span class="font-black text-sm" style="color: #000;">{{ siteSettings.site_icon_letter || 'JK' }}</span>
          </div>
          <transition enter-active-class="transition-all duration-200 ease-out" enter-from-class="opacity-0 -translate-x-2" enter-to-class="opacity-100 translate-x-0"
                      leave-active-class="transition-all duration-150 ease-in" leave-from-class="opacity-100 translate-x-0" leave-to-class="opacity-0 -translate-x-2">
            <div v-if="!sidebarCollapsed" class="min-w-0">
              <span class="font-bold text-[15px] tracking-tight block leading-tight whitespace-nowrap" :style="{ color: tc.theme_text_primary }">{{ siteSettings.site_name || 'jaykod.io' }}</span>
              <span class="text-[10px] font-semibold uppercase tracking-widest whitespace-nowrap" :style="{ color: tc.theme_accent }">Admin Panel</span>
            </div>
          </transition>
        </Link>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 py-4 overflow-y-auto overflow-x-hidden scrollbar-hide" :class="sidebarCollapsed ? 'px-2' : 'px-3'"
           style="-ms-overflow-style: none; scrollbar-width: none;">
        <p v-if="!sidebarCollapsed" class="px-3 pt-1 pb-2 text-[10px] font-bold uppercase tracking-[0.12em]" :style="{ color: tc.theme_text_secondary }">Main Menu</p>
        <div class="space-y-0.5">
          <Link v-for="item in navItems" :key="item.route" :href="route(item.route)"
                class="flex items-center rounded-xl text-[13px] font-medium transition-all duration-200 group relative"
                :class="[sidebarCollapsed ? 'justify-center px-0 py-2.5' : 'gap-3 px-3 py-2.5']"
                :style="navItemStyle(item.route)"
                @mouseenter="!isActive(item.route) && ($event.currentTarget.style.background = tc.theme_bg_tertiary, $event.currentTarget.style.color = tc.theme_text_primary)"
                @mouseleave="!isActive(item.route) && ($event.currentTarget.style.background = 'transparent', $event.currentTarget.style.color = tc.theme_text_secondary)"
                :title="sidebarCollapsed ? item.label : ''">
            <span class="text-lg leading-none select-none flex-shrink-0" :class="isActive(item.route) ? '' : 'grayscale-[30%] group-hover:grayscale-0 transition'">{{ item.emoji }}</span>
            <span v-if="!sidebarCollapsed" class="whitespace-nowrap">{{ item.label }}</span>
            <div v-if="isActive(item.route) && !sidebarCollapsed" class="ml-auto w-1.5 h-1.5 rounded-full" :style="{ background: tc.theme_accent }"></div>
            <!-- Collapsed active indicator -->
            <div v-if="isActive(item.route) && sidebarCollapsed" class="absolute right-0 top-1/2 -translate-y-1/2 w-[3px] h-4 rounded-l-full" :style="{ background: tc.theme_accent }"></div>
            <!-- Tooltip on collapsed -->
            <div v-if="sidebarCollapsed" class="absolute left-full ml-2 px-2.5 py-1.5 text-xs font-medium rounded-lg opacity-0 pointer-events-none group-hover:opacity-100 transition-opacity whitespace-nowrap z-50 shadow-lg"
                 :style="{ background: tc.theme_bg_tertiary, color: tc.theme_text_primary, border: `1px solid ${tc.theme_border}` }">
              {{ item.label }}
              <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent" :style="{ borderRightColor: tc.theme_bg_tertiary }"></div>
            </div>
          </Link>
        </div>
      </nav>

      <!-- User Section -->
      <div class="p-2" :class="sidebarCollapsed ? 'px-2' : 'p-3'" :style="{ borderTop: `1px solid ${tc.theme_border}` }">
        <div v-if="!sidebarCollapsed" class="flex items-center gap-3 px-3 py-2.5 rounded-xl mb-2" :style="{ background: tc.theme_bg_tertiary }">
          <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0" :style="{ background: tc.theme_accent + '20', color: tc.theme_accent }">
            {{ ($page.props.auth?.user?.name || 'A').charAt(0).toUpperCase() }}
          </div>
          <div class="min-w-0 flex-1">
            <div class="text-sm font-semibold truncate" :style="{ color: tc.theme_text_primary }">{{ $page.props.auth?.user?.name }}</div>
            <div class="text-[11px] truncate" :style="{ color: tc.theme_text_secondary }">{{ $page.props.auth?.user?.email }}</div>
          </div>
        </div>
        <div v-else class="flex justify-center mb-2">
          <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold" :style="{ background: tc.theme_accent + '20', color: tc.theme_accent }" :title="$page.props.auth?.user?.name">
            {{ ($page.props.auth?.user?.name || 'A').charAt(0).toUpperCase() }}
          </div>
        </div>
        <Link :href="route('admin.logout')" method="post" as="button"
              class="flex items-center gap-2.5 w-full rounded-lg text-[13px] transition-colors hover:bg-red-500/10 hover:text-red-400"
              :class="sidebarCollapsed ? 'justify-center px-2 py-2' : 'px-3 py-2'"
              :style="{ color: tc.theme_text_secondary }">
          <span class="text-base">🚪</span>
          <span v-if="!sidebarCollapsed">Sign Out</span>
        </Link>
      </div>
    </aside>

    <!-- Overlay for mobile -->
    <transition enter-active-class="transition-opacity duration-300" enter-from-class="opacity-0" leave-active-class="transition-opacity duration-200" leave-to-class="opacity-0">
      <div v-if="sidebarMobileOpen" @click="sidebarMobileOpen = false" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-20 lg:hidden" />
    </transition>

    <!-- Main Content -->
    <div class="flex-1 min-h-screen flex flex-col transition-all duration-300" :class="sidebarCollapsed ? 'lg:ml-[72px]' : 'lg:ml-[260px]'">
      <!-- Top bar / Header -->
      <header class="h-14 w-full backdrop-blur-xl flex items-center justify-between px-4 lg:px-6 sticky top-0 z-10"
              :style="{ background: tc.theme_bg_secondary + 'cc', borderBottom: `1px solid ${tc.theme_border}` }">
        <div class="flex items-center gap-2">
          <!-- Mobile menu toggle -->
          <button @click="sidebarMobileOpen = !sidebarMobileOpen" class="lg:hidden p-2 rounded-xl transition"
                  :style="{ color: tc.theme_text_secondary }"
                  @mouseenter="$event.target.style.color = tc.theme_accent"
                  @mouseleave="$event.target.style.color = tc.theme_text_secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!sidebarMobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
          <!-- Desktop sidebar toggle -->
          <button @click="sidebarCollapsed = !sidebarCollapsed" class="hidden lg:flex p-2 rounded-xl transition" title="Toggle sidebar"
                  :style="{ color: tc.theme_text_secondary }"
                  @mouseenter="$event.target.style.color = tc.theme_accent"
                  @mouseleave="$event.target.style.color = tc.theme_text_secondary">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path v-if="!sidebarCollapsed" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
              <path v-else stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
          </button>
          <!-- Breadcrumb / Page title in header -->
          <div class="hidden sm:flex items-center gap-2 ml-1">
            <span :style="{ color: tc.theme_border }">/</span>
            <span class="text-sm font-semibold" :style="{ color: tc.theme_text_primary }">{{ title }}</span>
          </div>
        </div>
        <div class="flex items-center gap-2">
          <a :href="route('portfolio')" target="_blank"
             class="inline-flex items-center gap-2 text-xs font-medium px-3.5 py-2 rounded-xl transition"
             :style="{ color: tc.theme_text_secondary, border: `1px solid ${tc.theme_border}` }"
             @mouseenter="$event.currentTarget.style.color = tc.theme_accent; $event.currentTarget.style.borderColor = tc.theme_accent + '50'"
             @mouseleave="$event.currentTarget.style.color = tc.theme_text_secondary; $event.currentTarget.style.borderColor = tc.theme_border">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
            </svg>
            View Site
          </a>
        </div>
      </header>

      <!-- Page Hero Header -->
      <div class="relative overflow-hidden" :style="{ background: `linear-gradient(135deg, ${tc.theme_accent}15, ${tc.theme_bg_tertiary}, ${tc.theme_bg_primary})` }">
        <!-- Texture pattern -->
        <div class="absolute inset-0" :style="{ backgroundImage: `linear-gradient(${tc.theme_accent}08 1px, transparent 1px), linear-gradient(90deg, ${tc.theme_accent}08 1px, transparent 1px), radial-gradient(${tc.theme_accent}0a 1px, transparent 1px)`, backgroundSize: '24px 24px, 24px 24px, 24px 24px' }"></div>
        <div class="relative px-4 lg:px-6 py-7 lg:py-9">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
              <div class="w-[52px] h-[52px] rounded-2xl backdrop-blur-sm flex items-center justify-center shadow-lg"
                   :style="{ background: tc.theme_accent + '15', border: `1px solid ${tc.theme_accent}25`, boxShadow: `0 4px 20px ${tc.theme_accent}10` }">
                <slot name="hero-icon">
                  <span class="text-2xl select-none">📋</span>
                </slot>
              </div>
              <div>
                <h1 class="text-2xl lg:text-[28px] font-extrabold tracking-tight leading-tight" :style="{ color: tc.theme_text_primary }">{{ title }}</h1>
                <p v-if="subtitle" class="text-sm mt-0.5 font-medium" :style="{ color: tc.theme_text_secondary }">{{ subtitle }}</p>
              </div>
            </div>
            <slot name="hero-actions" />
          </div>
        </div>
      </div>

      <main class="flex-1 p-4 lg:p-6 -mt-4">
        <!-- Flash Messages -->
        <transition enter-active-class="transition ease-out duration-300" enter-from-class="opacity-0 translate-y-2" enter-to-class="opacity-100 translate-y-0">
          <div v-if="$page.props.flash?.success" class="mb-6 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-2 shadow-sm"
               :style="{ background: tc.theme_accent + '15', border: `1px solid ${tc.theme_accent}30`, color: tc.theme_accent }">
            <span class="text-base">✅</span>
            {{ $page.props.flash.success }}
          </div>
        </transition>
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  title: String,
  subtitle: { type: String, default: '' },
  heroGradient: { type: String, default: '' },
});

const sidebarCollapsed = ref(false);
const sidebarMobileOpen = ref(false);
const page = usePage();
const siteSettings = computed(() => page.props.siteSettings || {});

// Theme colors from database with fallback defaults
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

const rootStyle = computed(() => ({
  background: tc.value.theme_bg_primary,
  color: tc.value.theme_text_primary,
  '--bg-primary': tc.value.theme_bg_primary,
  '--bg-secondary': tc.value.theme_bg_secondary,
  '--bg-tertiary': tc.value.theme_bg_tertiary,
  '--accent': tc.value.theme_accent,
  '--text-primary': tc.value.theme_text_primary,
  '--text-secondary': tc.value.theme_text_secondary,
  '--border-color': tc.value.theme_border,
}));

const isActive = (routeName) => {
  return route().current(routeName + '*') || route().current(routeName);
};

const navItemStyle = (routeName) => {
  if (isActive(routeName)) {
    return {
      background: tc.value.theme_accent + '12',
      color: tc.value.theme_accent,
      boxShadow: `inset 0 0 0 1px ${tc.value.theme_accent}15`,
    };
  }
  return { color: tc.value.theme_text_secondary };
};

const navItems = [
  { label: 'Dashboard', route: 'admin.dashboard', emoji: '📊' },
  { label: 'Profile', route: 'admin.profile-sections.index', emoji: '👤' },
  { label: 'Skills', route: 'admin.skills.index', emoji: '⚡' },
  { label: 'Experience', route: 'admin.experiences.index', emoji: '💼' },
  { label: 'Projects', route: 'admin.projects.index', emoji: '🚀' },
  { label: 'Education', route: 'admin.education.index', emoji: '🎓' },
  { label: 'Certifications', route: 'admin.certifications.index', emoji: '🏅' },
  { label: 'Contact Info', route: 'admin.contact-info.index', emoji: '📬' },
  { label: 'Templates', route: 'admin.templates.index', emoji: '📐' },
  { label: 'Site Settings', route: 'admin.settings.index', emoji: '⚙️' },
  { label: 'Theme', route: 'admin.theme.index', emoji: '🎨' },
  { label: 'Database', route: 'admin.database.index', emoji: '🗄️' },
];
</script>

<style scoped>
.scrollbar-hide::-webkit-scrollbar {
  display: none;
}
</style>
