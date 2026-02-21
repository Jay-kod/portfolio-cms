<template>
  <Head :title="title">
    <meta name="robots" content="noindex, nofollow">
  </Head>

  <div class="min-h-screen flex items-center justify-center px-4 py-16 relative overflow-hidden" style="background-color: #0a0a0a;">
    <!-- Animated background grid -->
    <div class="absolute inset-0 opacity-30"
         style="background-image: radial-gradient(rgba(0,255,136,0.06) 1px, transparent 1px); background-size: 40px 40px;">
    </div>

    <!-- Floating orbs -->
    <div class="absolute top-1/4 left-1/4 w-64 h-64 rounded-full blur-[120px] animate-pulse"
         style="background: rgba(0,255,136,0.08);"></div>
    <div class="absolute bottom-1/4 right-1/4 w-48 h-48 rounded-full blur-[100px] animate-pulse"
         style="background: rgba(0,255,136,0.05); animation-delay: 1s;"></div>

    <!-- Content -->
    <div class="relative z-10 text-center max-w-2xl mx-auto">

      <!-- Error code with glitch effect -->
      <div class="relative mb-6">
        <h1 class="text-[10rem] sm:text-[14rem] font-black leading-none select-none"
            style="color: rgba(0,255,136,0.08);">
          {{ status }}
        </h1>
        <h1 class="absolute inset-0 flex items-center justify-center text-[10rem] sm:text-[14rem] font-black leading-none select-none glitch-text"
            style="color: #00ff88; text-shadow: 0 0 40px rgba(0,255,136,0.3);">
          {{ status }}
        </h1>
      </div>

      <!-- Error icon -->
      <div class="flex justify-center mb-8">
        <div class="w-20 h-20 rounded-2xl flex items-center justify-center border"
             style="background: rgba(0,255,136,0.05); border-color: rgba(0,255,136,0.15);">
          <!-- 404 icon -->
          <svg v-if="status === 404" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.182 16.318A4.486 4.486 0 0012.016 15a4.486 4.486 0 00-3.198 1.318M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
          </svg>
          <!-- 403 icon -->
          <svg v-else-if="status === 403" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
          </svg>
          <!-- 500 icon -->
          <svg v-else-if="status === 500" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
          </svg>
          <!-- 503 icon -->
          <svg v-else-if="status === 503" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17l-5.658 3.286a.75.75 0 01-1.112-.66V5.603a.75.75 0 011.112-.66l5.658 3.286m0 0l5.658-3.286a.75.75 0 011.112.66v12.193a.75.75 0 01-1.112.66l-5.658-3.286m0 0V8.354m0 3.462V8.354m0 3.462l5.658 3.286" />
          </svg>
          <!-- 419 icon -->
          <svg v-else-if="status === 419" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
          </svg>
          <!-- 429 icon -->
          <svg v-else-if="status === 429" class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l8.735 8.735m0 0a.374.374 0 11.53.53m-.53-.53l.53.53m0 0L21 21M14.652 9.348a3.75 3.75 0 010 5.304m2.121-7.425a6.75 6.75 0 010 9.546m2.121-11.667C21.583 7.794 23 10.27 23 13s-1.417 5.206-4.106 7.794M3.553 5.106A12.21 12.21 0 011 13c0 2.73 1.417 5.206 4.106 7.794" />
          </svg>
          <!-- Default icon -->
          <svg v-else class="w-10 h-10" style="color: #00ff88;" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
          </svg>
        </div>
      </div>

      <!-- Title -->
      <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">
        {{ title }}
      </h2>

      <!-- Description -->
      <p class="text-lg text-gray-400 mb-10 max-w-lg mx-auto leading-relaxed">
        {{ description }}
      </p>

      <!-- Action buttons -->
      <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
        <!-- Go Home -->
        <a href="/"
           class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl text-sm font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5"
           style="background-color: #00ff88; color: #000;">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
          </svg>
          Back to Home
        </a>

        <!-- Go Back -->
        <button @click="goBack"
                class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl text-sm font-bold transition-all border-2 hover:bg-white/5"
                style="border-color: rgba(255,255,255,0.15); color: #fff;">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
          </svg>
          Go Back
        </button>

        <!-- Refresh (for 500/503) -->
        <button v-if="status === 500 || status === 503"
                @click="refresh"
                class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-xl text-sm font-bold transition-all border-2 hover:bg-white/5"
                style="border-color: rgba(0,255,136,0.2); color: #00ff88;">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182" />
          </svg>
          Try Again
        </button>
      </div>

      <!-- Helpful suggestions for 404 -->
      <div v-if="status === 404" class="mt-12 pt-8 border-t" style="border-color: #1f1f1f;">
        <p class="text-sm text-gray-500 mb-5">Looking for something? Try these:</p>
        <div class="flex flex-wrap items-center justify-center gap-3">
          <a v-for="link in suggestedLinks" :key="link.href"
             :href="link.href"
             class="px-4 py-2 rounded-lg text-sm font-medium transition-all hover:-translate-y-0.5"
             style="background: rgba(255,255,255,0.05); color: #9ca3af; border: 1px solid rgba(255,255,255,0.08);"
             @mouseenter="$event.target.style.color = '#00ff88'; $event.target.style.borderColor = 'rgba(0,255,136,0.2)'"
             @mouseleave="$event.target.style.color = '#9ca3af'; $event.target.style.borderColor = 'rgba(255,255,255,0.08)'">
            {{ link.label }}
          </a>
        </div>
      </div>

      <!-- Status indicator for 503 -->
      <div v-if="status === 503" class="mt-12 pt-8 border-t" style="border-color: #1f1f1f;">
        <div class="inline-flex items-center gap-2.5 px-4 py-2.5 rounded-full text-sm"
             style="background: rgba(251,191,36,0.08); border: 1px solid rgba(251,191,36,0.15); color: #fbbf24;">
          <span class="w-2 h-2 rounded-full animate-pulse" style="background: #fbbf24;"></span>
          We're working on it — check back soon
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  status: {
    type: Number,
    required: true,
  },
});

const titles = {
  403: 'Access Denied',
  404: 'Page Not Found',
  419: 'Session Expired',
  429: 'Too Many Requests',
  500: 'Server Error',
  503: 'Under Maintenance',
};

const descriptions = {
  403: "You don't have permission to access this page. If you believe this is an error, please contact the site administrator.",
  404: "The page you're looking for doesn't exist or has been moved. It might have been removed, renamed, or the URL may be incorrect.",
  419: 'Your session has expired due to inactivity. Please refresh the page and try again to continue where you left off.',
  429: "You've sent too many requests in a short period. Please wait a moment before trying again.",
  500: 'Something went wrong on our end. Our team has been notified and is working to fix the issue. Please try again in a few moments.',
  503: "We're currently performing scheduled maintenance to improve your experience. We'll be back online shortly.",
};

const title = computed(() => titles[props.status] || `Error ${props.status}`);
const description = computed(() => descriptions[props.status] || 'An unexpected error occurred. Please try again later.');

const suggestedLinks = [
  { href: '/', label: 'Home' },
  { href: '/about', label: 'About' },
  { href: '/experience', label: 'Experience' },
  { href: '/projects', label: 'Projects' },
  { href: '/contact', label: 'Contact' },
  { href: '/resume/create', label: 'Get Resume' },
];

function goBack() {
  if (window.history.length > 1) {
    window.history.back();
  } else {
    window.location.href = '/';
  }
}

function refresh() {
  window.location.reload();
}
</script>

<style scoped>
@keyframes glitch {
  0%, 100% {
    clip-path: inset(0 0 0 0);
    transform: translate(0);
  }
  20% {
    clip-path: inset(20% 0 60% 0);
    transform: translate(-2px, 2px);
  }
  40% {
    clip-path: inset(40% 0 30% 0);
    transform: translate(2px, -2px);
  }
  60% {
    clip-path: inset(60% 0 10% 0);
    transform: translate(-1px, 1px);
  }
  80% {
    clip-path: inset(10% 0 80% 0);
    transform: translate(1px, -1px);
  }
}

.glitch-text {
  animation: glitch 4s ease-in-out infinite;
  animation-delay: 2s;
}
</style>
