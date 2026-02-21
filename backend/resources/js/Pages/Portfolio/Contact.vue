<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 overflow-hidden">
      <div class="absolute inset-0 bg-[#0a0a0a]"></div>
      <div class="absolute inset-0" style="background-image: repeating-radial-gradient(circle at 0% 50%, transparent 0, transparent 15px, rgba(0,255,136,0.06) 16px, transparent 17px), repeating-radial-gradient(circle at 100% 50%, transparent 0, transparent 20px, rgba(0,255,136,0.05) 21px, transparent 22px), repeating-linear-gradient(0deg, transparent, transparent 25px, rgba(0,255,136,0.03) 25px, rgba(0,255,136,0.03) 26px);"></div>
      <!-- Floating accents -->
      <div class="absolute top-20 left-10 w-64 h-64 bg-[#00ff88]/10 rounded-full blur-3xl"></div>
      <div class="absolute bottom-10 right-10 w-80 h-80 bg-[#00ff88]/10 rounded-full blur-3xl"></div>
      <div class="absolute top-32 right-20 w-3 h-3 bg-[#00ff88] rounded-full animate-pulse"></div>
      <div class="absolute bottom-20 left-1/4 w-2 h-2 bg-[#00ff88]/60 rounded-full animate-pulse" style="animation-delay: 1s"></div>

      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-3xl mb-8 border border-white/20 shadow-xl shadow-[#00ff88]/20">
          <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>
        </div>
        <h1 class="text-4xl md:text-6xl font-black text-white mb-5 tracking-tight">Let's Work Together</h1>
        <p class="text-lg md:text-xl text-gray-400 max-w-2xl mx-auto leading-relaxed">
          Have a project in mind or want to collaborate? I'd love to hear from you. Feel free to reach out through any of the channels below.
        </p>
        <!-- Availability badge -->
        <div class="inline-flex items-center gap-2 mt-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full px-5 py-2.5">
          <span class="relative flex h-2.5 w-2.5">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-emerald-400"></span>
          </span>
          <span class="text-sm font-medium text-white/90">Available for new opportunities</span>
        </div>
      </div>
    </section>

    <!-- Stats Banner -->
    <section class="relative z-10 -mt-8">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-[#111] rounded-2xl shadow-xl border border-[#1f1f1f] p-1">
          <div class="grid grid-cols-2 md:grid-cols-4 divide-x divide-[#1f1f1f]">
            <div class="p-5 text-center">
              <div class="text-2xl font-black text-[#00ff88]">{{ channelCount }}</div>
              <div class="text-xs font-medium text-gray-500 mt-1">Contact Channels</div>
            </div>
            <div class="p-5 text-center">
              <div class="text-2xl font-black text-[#00ff88]">{{ socialCount }}</div>
              <div class="text-xs font-medium text-gray-500 mt-1">Social Profiles</div>
            </div>
            <div class="p-5 text-center">
              <div class="text-2xl font-black text-amber-500">&lt; 24h</div>
              <div class="text-xs font-medium text-gray-500 mt-1">Response Time</div>
            </div>
            <div class="p-5 text-center">
              <div class="text-2xl font-black text-emerald-500">Open</div>
              <div class="text-xs font-medium text-gray-500 mt-1">Availability</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Content -->
    <section class="py-20 bg-[#0a0a0a]">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Bio/Intro -->
        <div v-if="bio" class="text-center mb-16">
          <p class="text-lg text-gray-400 leading-relaxed max-w-3xl mx-auto">{{ bio.content }}</p>
        </div>

        <!-- Primary Contact Section -->
        <div v-if="primaryContacts.length" class="mb-16">
          <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-[#00ff88]/10 rounded-xl flex items-center justify-center">
              <svg class="w-5 h-5 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.518 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.518-4.674z" /></svg>
            </div>
            <div>
              <h2 class="text-xl font-bold text-white">Preferred Contact</h2>
              <p class="text-sm text-gray-500">Best ways to reach me directly</p>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <a v-for="c in primaryContacts" :key="c.id"
               :href="getContactHref(c)" target="_blank" rel="noopener noreferrer"
               class="group relative bg-[#111] rounded-2xl p-6 border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:shadow-xl hover:shadow-[#00ff88]/10 transition-all duration-300 hover:-translate-y-1">
              <div class="absolute top-4 right-4">
                <span class="text-xs bg-[#00ff88]/10 text-[#00ff88] px-2.5 py-1 rounded-full font-semibold">Primary</span>
              </div>
              <div class="flex items-start gap-5">
                <div :class="['w-14 h-14 rounded-2xl flex items-center justify-center shrink-0 transition-colors duration-300', getIconBg(c.type), 'group-hover:' + getIconBgHover(c.type)]">
                  <component :is="'div'" v-html="getTypeIcon(c.type, getIconColor(c.type))" />
                </div>
                <div class="min-w-0">
                  <div class="text-xs font-semibold uppercase tracking-wider mb-1" :class="getIconColor(c.type)">{{ getTypeLabel(c.type) }}</div>
                  <h3 class="font-bold text-white text-lg group-hover:text-[#00ff88] transition-colors">{{ c.display_name }}</h3>
                  <p class="text-sm text-gray-500 mt-1 truncate">{{ c.value }}</p>
                </div>
              </div>
              <div class="mt-4 flex items-center gap-1.5 text-sm font-medium text-[#00ff88] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span>{{ getActionLabel(c.type) }}</span>
                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
              </div>
            </a>
          </div>
        </div>

        <!-- All Contact Channels -->
        <div class="mb-16">
          <div class="flex items-center gap-3 mb-8">
            <div class="w-10 h-10 bg-[#00ff88]/10 rounded-xl flex items-center justify-center">
              <svg class="w-5 h-5 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
            </div>
            <div>
              <h2 class="text-xl font-bold text-white">All Channels</h2>
              <p class="text-sm text-gray-500">Connect with me across platforms</p>
            </div>
          </div>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
            <a v-for="c in contact" :key="c.id"
               :href="getContactHref(c)" target="_blank" rel="noopener noreferrer"
               class="group bg-[#111] rounded-2xl p-6 border border-[#1f1f1f] hover:border-[#00ff88]/20 hover:shadow-xl hover:shadow-[#00ff88]/10 transition-all duration-300 hover:-translate-y-1">
              <div class="flex items-center gap-4 mb-4">
                <div :class="['w-12 h-12 rounded-xl flex items-center justify-center shrink-0 transition-colors duration-300', getIconBg(c.type)]">
                  <component :is="'div'" v-html="getTypeIcon(c.type, getIconColor(c.type))" />
                </div>
                <div class="min-w-0 flex-1">
                  <h3 class="font-bold text-white group-hover:text-[#00ff88] transition-colors">{{ c.display_name }}</h3>
                  <p class="text-xs font-medium uppercase tracking-wider mt-0.5" :class="getIconColor(c.type)">{{ getTypeLabel(c.type) }}</p>
                </div>
              </div>
              <p class="text-sm text-gray-500 truncate mb-3">{{ c.value }}</p>
              <div class="flex items-center gap-1.5 text-sm font-medium text-[#00ff88] opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <span>{{ getActionLabel(c.type) }}</span>
                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
              </div>
            </a>
          </div>
        </div>

        <!-- Quick Connect CTA -->
        <div class="relative overflow-hidden bg-[#111] rounded-3xl p-10 md:p-14 border border-[#1f1f1f]">
          <div class="absolute top-0 right-0 w-72 h-72 bg-[#00ff88]/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>
          <div class="absolute bottom-0 left-0 w-56 h-56 bg-[#00ff88]/5 rounded-full blur-3xl translate-y-1/2 -translate-x-1/3"></div>
          <div class="relative flex flex-col md:flex-row items-center gap-8">
            <div class="flex-1 text-center md:text-left">
              <h3 class="text-2xl md:text-3xl font-black text-white mb-3">Ready to Build Something Amazing?</h3>
              <p class="text-gray-400 max-w-lg">Whether it's a new project, consulting, or just a chat about tech — I'm always excited to connect with fellow developers and innovators.</p>
            </div>
            <div class="flex flex-col gap-3 shrink-0">
              <a v-if="primaryEmail" :href="'mailto:' + primaryEmail.value"
                 class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-8 py-4 rounded-2xl font-bold text-lg hover:bg-[#00cc6a] transition-all shadow-lg hover:shadow-xl hover:-translate-y-1">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                Send an Email
              </a>
              <Link :href="route('resume.create')"
                    class="inline-flex items-center justify-center gap-2 bg-white/10 backdrop-blur-sm text-white border border-white/20 px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Generate Resume
              </Link>
            </div>
          </div>
        </div>

      </div>
    </section>
  </PortfolioLayout>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import PortfolioLayout from '@/Layouts/PortfolioLayout.vue';

const props = defineProps({
  meta: Object,
  contact: Array,
  profile: Array,
});

const bio = computed(() => props.profile?.find(p => p.section_name === 'bio'));

const primaryContacts = computed(() => props.contact?.filter(c => c.is_primary) || []);
const primaryEmail = computed(() => props.contact?.find(c => c.type === 'email') || null);

const socialTypes = ['linkedin', 'github', 'twitter', 'website', 'facebook', 'youtube', 'tiktok', 'whatsapp', 'instagram', 'telegram', 'discord', 'snapchat', 'reddit', 'medium', 'stackoverflow', 'dribbble', 'behance', 'twitch', 'pinterest', 'skype'];
const channelCount = computed(() => props.contact?.length || 0);
const socialCount = computed(() => props.contact?.filter(c => socialTypes.includes(c.type)).length || 0);

const getContactHref = (c) => {
  if (c.type === 'email') return `mailto:${c.value}`;
  if (c.type === 'phone') return `tel:${c.value}`;
  if (c.type === 'whatsapp') return `https://wa.me/${c.value.replace(/[^0-9]/g, '')}`;
  return c.value.startsWith('http') ? c.value : `https://${c.value}`;
};

const getTypeLabel = (type) => {
  const labels = {
    email: 'Email', phone: 'Phone', linkedin: 'LinkedIn', github: 'GitHub',
    twitter: 'Twitter / X', website: 'Website', address: 'Location',
    facebook: 'Facebook', youtube: 'YouTube', tiktok: 'TikTok',
    whatsapp: 'WhatsApp', instagram: 'Instagram', telegram: 'Telegram',
    discord: 'Discord', snapchat: 'Snapchat', reddit: 'Reddit',
    medium: 'Medium', stackoverflow: 'Stack Overflow', dribbble: 'Dribbble',
    behance: 'Behance', twitch: 'Twitch', pinterest: 'Pinterest', skype: 'Skype',
  };
  return labels[type] || type;
};

const getActionLabel = (type) => {
  const actions = {
    email: 'Send email', phone: 'Call now', linkedin: 'View profile', github: 'View repos',
    twitter: 'Follow', website: 'Visit site', address: 'View map',
    facebook: 'View profile', youtube: 'Subscribe', tiktok: 'Follow',
    whatsapp: 'Message', instagram: 'Follow', telegram: 'Message',
    discord: 'Join', snapchat: 'Add me', reddit: 'View profile',
    medium: 'Read articles', stackoverflow: 'View profile', dribbble: 'View shots',
    behance: 'View portfolio', twitch: 'Watch', pinterest: 'Follow', skype: 'Call',
  };
  return actions[type] || 'Open';
};

const getIconBg = (type) => {
  const bgs = {
    email: 'bg-red-500/10', phone: 'bg-emerald-500/10', linkedin: 'bg-blue-500/10',
    github: 'bg-gray-500/10', twitter: 'bg-gray-500/10', website: 'bg-amber-500/10',
    address: 'bg-rose-500/10', facebook: 'bg-blue-500/10', youtube: 'bg-red-500/10',
    tiktok: 'bg-gray-500/10', whatsapp: 'bg-green-500/10', instagram: 'bg-pink-500/10',
    telegram: 'bg-sky-500/10', discord: 'bg-indigo-500/10', snapchat: 'bg-yellow-500/10',
    reddit: 'bg-orange-500/10', medium: 'bg-gray-500/10', stackoverflow: 'bg-orange-500/10',
    dribbble: 'bg-pink-500/10', behance: 'bg-blue-500/10', twitch: 'bg-purple-500/10',
    pinterest: 'bg-red-500/10', skype: 'bg-sky-500/10',
  };
  return bgs[type] || 'bg-gray-500/10';
};

const getIconBgHover = (type) => {
  return getIconBg(type).replace('/10', '/20');
};

const getIconColor = (type) => {
  const colors = {
    email: 'text-red-400', phone: 'text-emerald-400', linkedin: 'text-blue-400',
    github: 'text-gray-300', twitter: 'text-gray-300', website: 'text-amber-400',
    address: 'text-rose-400', facebook: 'text-blue-400', youtube: 'text-red-400',
    tiktok: 'text-gray-300', whatsapp: 'text-green-400', instagram: 'text-pink-400',
    telegram: 'text-sky-400', discord: 'text-indigo-400', snapchat: 'text-yellow-400',
    reddit: 'text-orange-400', medium: 'text-gray-300', stackoverflow: 'text-orange-400',
    dribbble: 'text-pink-400', behance: 'text-blue-400', twitch: 'text-purple-400',
    pinterest: 'text-red-400', skype: 'text-sky-400',
  };
  return colors[type] || 'text-gray-400';
};

const getTypeIcon = (type, colorClass) => {
  const icons = {
    email: `<svg class="w-6 h-6 ${colorClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>`,
    phone: `<svg class="w-6 h-6 ${colorClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>`,
    linkedin: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>`,
    github: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>`,
    twitter: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>`,
    website: `<svg class="w-6 h-6 ${colorClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" /></svg>`,
    address: `<svg class="w-6 h-6 ${colorClass}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>`,
    facebook: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>`,
    youtube: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>`,
    tiktok: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/></svg>`,
    whatsapp: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>`,
    instagram: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0C8.74 0 8.333.015 7.053.072 5.775.132 4.905.333 4.14.63c-.789.306-1.459.717-2.126 1.384S.935 3.35.63 4.14C.333 4.905.131 5.775.072 7.053.012 8.333 0 8.74 0 12s.015 3.667.072 4.947c.06 1.277.261 2.148.558 2.913.306.788.717 1.459 1.384 2.126.667.666 1.336 1.079 2.126 1.384.766.296 1.636.499 2.913.558C8.333 23.988 8.74 24 12 24s3.667-.015 4.947-.072c1.277-.06 2.148-.262 2.913-.558.788-.306 1.459-.718 2.126-1.384.666-.667 1.079-1.335 1.384-2.126.296-.765.499-1.636.558-2.913.06-1.28.072-1.687.072-4.947s-.015-3.667-.072-4.947c-.06-1.277-.262-2.149-.558-2.913-.306-.789-.718-1.459-1.384-2.126C21.319 1.347 20.651.935 19.86.63c-.765-.297-1.636-.499-2.913-.558C15.667.012 15.26 0 12 0zm0 2.16c3.203 0 3.585.016 4.85.071 1.17.055 1.805.249 2.227.415.562.217.96.477 1.382.896.419.42.679.819.896 1.381.164.422.36 1.057.413 2.227.057 1.266.07 1.646.07 4.85s-.015 3.585-.074 4.85c-.061 1.17-.256 1.805-.421 2.227-.224.562-.479.96-.899 1.382-.419.419-.824.679-1.38.896-.42.164-1.065.36-2.235.413-1.274.057-1.649.07-4.859.07-3.211 0-3.586-.015-4.859-.074-1.171-.061-1.816-.256-2.236-.421-.569-.224-.96-.479-1.379-.899-.421-.419-.69-.824-.9-1.38-.165-.42-.359-1.065-.42-2.235-.045-1.26-.061-1.649-.061-4.844 0-3.196.016-3.586.061-4.861.061-1.17.255-1.814.42-2.234.21-.57.479-.96.9-1.381.419-.419.81-.689 1.379-.898.42-.166 1.051-.361 2.221-.421 1.275-.045 1.65-.06 4.859-.06l.045.03zm0 3.678a6.162 6.162 0 100 12.324 6.162 6.162 0 100-12.324zM12 16c-2.21 0-4-1.79-4-4s1.79-4 4-4 4 1.79 4 4-1.79 4-4 4zm7.846-10.405a1.441 1.441 0 11-2.882 0 1.441 1.441 0 012.882 0z"/></svg>`,
    telegram: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.479.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/></svg>`,
    discord: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M20.317 4.3698a19.7913 19.7913 0 00-4.8851-1.5152.0741.0741 0 00-.0785.0371c-.211.3753-.4447.8648-.6083 1.2495-1.8447-.2762-3.68-.2762-5.4868 0-.1636-.3933-.4058-.8742-.6177-1.2495a.077.077 0 00-.0785-.037 19.7363 19.7363 0 00-4.8852 1.515.0699.0699 0 00-.0321.0277C.5334 9.0458-.319 13.5799.0992 18.0578a.0824.0824 0 00.0312.0561c2.0528 1.5076 4.0413 2.4228 5.9929 3.0294a.0777.0777 0 00.0842-.0276c.4616-.6304.8731-1.2952 1.226-1.9942a.076.076 0 00-.0416-.1057c-.6528-.2476-1.2743-.5495-1.8722-.8923a.077.077 0 01-.0076-.1277c.1258-.0943.2517-.1923.3718-.2914a.0743.0743 0 01.0776-.0105c3.9278 1.7933 8.18 1.7933 12.0614 0a.0739.0739 0 01.0785.0095c.1202.099.246.1981.3728.2924a.077.077 0 01-.0066.1276 12.2986 12.2986 0 01-1.873.8914.0766.0766 0 00-.0407.1067c.3604.698.7719 1.3628 1.225 1.9932a.076.076 0 00.0842.0286c1.961-.6067 3.9495-1.5219 6.0023-3.0294a.077.077 0 00.0313-.0552c.5004-5.177-.8382-9.6739-3.5485-13.6604a.061.061 0 00-.0312-.0286zM8.02 15.3312c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9555-2.4189 2.157-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.9555 2.4189-2.1569 2.4189zm7.9748 0c-1.1825 0-2.1569-1.0857-2.1569-2.419 0-1.3332.9554-2.4189 2.1569-2.4189 1.2108 0 2.1757 1.0952 2.1568 2.419 0 1.3332-.946 2.4189-2.1568 2.4189z"/></svg>`,
    snapchat: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/></svg>`,
    reddit: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0zm5.01 4.744c.688 0 1.25.561 1.25 1.249a1.25 1.25 0 0 1-2.498.056l-2.597-.547-.8 3.747c1.824.07 3.48.632 4.674 1.488.308-.309.73-.491 1.207-.491.968 0 1.754.786 1.754 1.754 0 .716-.435 1.333-1.01 1.614a3.111 3.111 0 0 1 .042.52c0 2.694-3.13 4.87-7.004 4.87-3.874 0-7.004-2.176-7.004-4.87 0-.183.015-.366.043-.534A1.748 1.748 0 0 1 4.028 12c0-.968.786-1.754 1.754-1.754.463 0 .898.196 1.207.49 1.207-.883 2.878-1.43 4.744-1.487l.885-4.182a.342.342 0 0 1 .14-.197.35.35 0 0 1 .238-.042l2.906.617a1.214 1.214 0 0 1 1.108-.701zM9.25 12C8.561 12 8 12.562 8 13.25c0 .687.561 1.248 1.25 1.248.687 0 1.248-.561 1.248-1.249 0-.688-.561-1.249-1.249-1.249zm5.5 0c-.687 0-1.248.561-1.248 1.25 0 .687.561 1.248 1.249 1.248.688 0 1.249-.561 1.249-1.249 0-.687-.562-1.249-1.25-1.249zm-5.466 3.99a.327.327 0 0 0-.231.094.33.33 0 0 0 0 .463c.842.842 2.484.913 2.961.913.477 0 2.105-.056 2.961-.913a.361.361 0 0 0 .029-.463.33.33 0 0 0-.464 0c-.547.533-1.684.73-2.512.73-.828 0-1.979-.196-2.512-.73a.326.326 0 0 0-.232-.095z"/></svg>`,
    medium: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M13.54 12a6.8 6.8 0 01-6.77 6.82A6.8 6.8 0 010 12a6.8 6.8 0 016.77-6.82A6.8 6.8 0 0113.54 12zM20.96 12c0 3.54-1.51 6.42-3.38 6.42-1.87 0-3.39-2.88-3.39-6.42s1.52-6.42 3.39-6.42 3.38 2.88 3.38 6.42M24 12c0 3.17-.53 5.75-1.19 5.75-.66 0-1.19-2.58-1.19-5.75s.53-5.75 1.19-5.75C23.47 6.25 24 8.83 24 12z"/></svg>`,
    stackoverflow: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M15.725 0l-1.72 1.277 6.39 8.588 1.716-1.277L15.725 0zm-3.94 3.418l-1.369 1.644 8.225 6.85 1.369-1.644-8.225-6.85zm-3.15 4.465l-.905 1.94 9.702 4.517.904-1.94-9.701-4.517zm-1.85 4.86l-.44 2.093 10.473 2.2.44-2.092-10.473-2.2zM1.89 15.47V24h19.19v-8.53h-2.133v6.397H4.021v-6.396H1.89zm4.265 2.133v2.13h10.66v-2.13H6.154z"/></svg>`,
    dribbble: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12 24C5.385 24 0 18.615 0 12S5.385 0 12 0s12 5.385 12 12-5.385 12-12 12zm10.12-10.358c-.35-.11-3.17-.953-6.384-.438 1.34 3.684 1.887 6.684 1.992 7.308 2.3-1.555 3.936-4.02 4.395-6.87zm-6.115 7.808c-.153-.9-.75-4.032-2.19-7.77l-.066.02c-5.79 2.015-7.86 6.025-8.04 6.4 1.73 1.358 3.92 2.166 6.29 2.166 1.42 0 2.77-.29 4-.81zm-11.62-2.58c.232-.4 3.045-5.055 8.332-6.765.135-.045.27-.084.405-.12-.26-.585-.54-1.167-.832-1.74C7.17 11.775 2.206 11.71 1.756 11.7l-.004.312c0 2.633.998 5.037 2.634 6.855zm-2.42-8.955c.46.008 4.683.026 9.477-1.248-1.698-3.018-3.53-5.558-3.8-5.928-2.868 1.35-5.01 3.99-5.676 7.17zM9.6 2.052c.282.38 2.145 2.914 3.822 6 3.645-1.365 5.19-3.44 5.373-3.702-1.81-1.61-4.19-2.586-6.795-2.586-.825 0-1.63.1-2.4.29zm10.335 3.483c-.218.29-1.91 2.493-5.724 4.04.24.49.47.985.68 1.486.08.18.15.36.22.53 3.41-.43 6.8.26 7.14.33-.02-2.42-.88-4.64-2.31-6.38z"/></svg>`,
    behance: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M6.938 4.503c.702 0 1.34.06 1.92.188.577.13 1.07.33 1.485.61.41.28.733.65.96 1.12.225.47.34 1.05.34 1.73 0 .74-.17 1.36-.507 1.86-.338.5-.837.9-1.502 1.22.906.26 1.576.72 2.022 1.37.448.66.665 1.45.665 2.36 0 .75-.13 1.39-.41 1.93-.28.55-.67 1-1.16 1.35-.48.348-1.05.6-1.67.767-.63.166-1.27.25-1.95.25H0v-14.7h6.938zm-.21 5.89c.638 0 1.16-.14 1.56-.44.4-.3.6-.75.6-1.33 0-.32-.06-.59-.174-.81a1.38 1.38 0 00-.48-.52 1.984 1.984 0 00-.73-.28 4.05 4.05 0 00-.91-.1H3.393v3.48h3.335zm.273 6.12c.35 0 .673-.028.97-.09.3-.06.56-.17.78-.31.22-.15.39-.35.52-.6.13-.26.19-.6.19-1 0-.78-.22-1.35-.66-1.7-.44-.36-1.03-.54-1.76-.54H3.393V16.5h3.608zM21.142 6.296h-5.684v-1.96h5.684v1.96zm-2.846 1.78c.87 0 1.59.147 2.17.44.58.295 1.04.677 1.38 1.15.34.47.57 1.01.7 1.62.126.61.19 1.24.19 1.89v.66H15.394c.04.97.345 1.7.91 2.17.567.47 1.28.7 2.14.7.618 0 1.17-.136 1.65-.41.48-.27.804-.64.96-1.1h2.97c-.36 1.18-1.01 2.08-1.94 2.68-.93.6-2.04.9-3.35.9-.858 0-1.64-.14-2.36-.42a5.1 5.1 0 01-1.84-1.22c-.51-.53-.904-1.17-1.19-1.92-.28-.75-.42-1.59-.42-2.52 0-.9.14-1.73.43-2.48.29-.75.69-1.39 1.2-1.93.52-.54 1.12-.96 1.83-1.25.71-.3 1.49-.45 2.34-.45zm2.59 4.62c-.05-.82-.34-1.47-.87-1.96-.53-.49-1.2-.73-2-.73-.54 0-1 .09-1.39.28-.38.19-.7.42-.94.71-.24.28-.42.6-.52.94-.1.33-.17.65-.18.97h5.9z"/></svg>`,
    twitch: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M11.571 4.714h1.715v5.143H11.57zm4.715 0H18v5.143h-1.714zM6 0L1.714 4.286v15.428h5.143V24l4.286-4.286h3.428L22.286 12V0zm14.571 11.143l-3.428 3.428h-3.429l-3 3v-3H6.857V1.714h13.714z"/></svg>`,
    pinterest: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 5.079 3.158 9.417 7.618 11.162-.105-.949-.199-2.403.041-3.439.219-.937 1.406-5.957 1.406-5.957s-.359-.72-.359-1.781c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12.017 24c6.624 0 11.99-5.367 11.99-11.988C24.007 5.367 18.641.001 12.017.001z"/></svg>`,
    skype: `<svg class="w-6 h-6 ${colorClass}" fill="currentColor" viewBox="0 0 24 24"><path d="M12.069 18.874c-4.023 0-5.82-1.979-5.82-3.464 0-.765.561-1.296 1.333-1.296 1.723 0 1.273 2.477 4.487 2.477 1.641 0 2.55-.895 2.55-1.811 0-.551-.269-1.16-1.354-1.429l-3.576-.949c-2.886-.765-3.417-2.418-3.417-3.966 0-3.219 3.024-4.429 5.863-4.429 2.614 0 5.382 1.443 5.382 3.125 0 .783-.666 1.246-1.384 1.246-1.468 0-1.195-2.027-4.175-2.027-1.471 0-2.267.704-2.267 1.572 0 .923.876 1.219 1.631 1.398l2.658.654c2.86.707 3.748 2.377 3.748 4.126 0 2.617-2.015 4.773-6.159 4.773zM23.431 16.69C24.244 15.24 24.721 13.574 24.721 11.788c0-7.03-5.699-12.73-12.73-12.73-1.91 0-3.693.434-5.308 1.176A6.919 6.919 0 003.389.898C1.517.898 0 2.416 0 4.288c0 1.07.5 2.018 1.269 2.643C.467 8.524 0 10.282 0 12.148c0 7.03 5.699 12.73 12.73 12.73 1.76 0 3.432-.362 4.966-1.002a6.889 6.889 0 003.716 1.097c1.872 0 3.389-1.517 3.389-3.389 0-1.276-.712-2.382-1.757-2.959l.387.065z"/></svg>`,
  };
  return icons[type] || icons.website;
};
</script>
