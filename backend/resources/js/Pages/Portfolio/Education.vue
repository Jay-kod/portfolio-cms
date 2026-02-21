<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 overflow-hidden">
      <div class="absolute inset-0 bg-[#0a0a0a]"></div>
      <div class="absolute inset-0" style="background-image: radial-gradient(rgba(0,255,136,0.15) 2px, transparent 2px), radial-gradient(rgba(0,255,136,0.08) 1.5px, transparent 1.5px), radial-gradient(rgba(0,255,136,0.04) 1px, transparent 1px); background-size: 40px 40px, 30px 30px, 15px 15px; background-position: 0 0, 15px 20px, 7px 12px;"></div>
      <!-- Floating accents -->
      <div class="absolute top-20 left-10 w-24 h-24 bg-[#00ff88]/10 rounded-full blur-2xl animate-pulse"></div>
      <div class="absolute bottom-10 right-16 w-36 h-36 bg-[#00ff88]/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-white/5 backdrop-blur-md rounded-3xl mb-6 border border-white/10 shadow-2xl shadow-[#00ff88]/10">
          <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zM12 14v7" /></svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Education</h1>
        <p class="text-lg text-[#00ff88] max-w-2xl mx-auto leading-relaxed">Academic foundations and professional certifications that drive my expertise.</p>
      </div>
    </section>

    <!-- Stats Banner -->
    <section class="relative z-10" style="background-color: #0a0a0a;">
      <div class="border-b border-[#1f1f1f]" style="background-color: #0a0a0a;">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ education?.length || 0 }}</div>
              <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Degrees</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ certifications?.length || 0 }}</div>
              <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Certifications</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ totalInstitutions }}</div>
              <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Institutions</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ totalAchievements }}</div>
              <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">Achievements</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Academic Degrees Section -->
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            Academic Degrees
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
          </h2>
          <p class="text-gray-400 text-sm max-w-lg mx-auto">The academic journey that built the foundation for my career.</p>
        </div>

        <div v-if="education?.length" class="relative">
          <!-- Timeline line -->
          <div class="absolute left-6 md:left-1/2 md:-translate-x-px top-0 bottom-0 w-0.5" style="background: linear-gradient(to bottom, #00ff88, rgba(0,255,136,0.3), transparent);"></div>

          <div v-for="(edu, index) in education" :key="edu.id"
               class="relative mb-12 last:mb-0"
               :class="index % 2 === 0 ? 'md:pr-[calc(50%+2rem)]' : 'md:pl-[calc(50%+2rem)]'">

            <!-- Timeline node -->
            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-8 z-10">
              <div class="w-4 h-4 rounded-full border-[3px] border-[#0a0a0a] shadow-md"
                   :class="edu.is_current ? 'bg-[#00ff88]' : eduNodeColors[index % eduNodeColors.length]">
              </div>
            </div>

            <!-- Card -->
            <div class="ml-16 md:ml-0 group">
              <div class="rounded-2xl border border-[#1f1f1f] shadow-sm hover:shadow-xl hover:border-[#00ff88]/20 transition-all duration-500 overflow-hidden" style="background-color: #111;">
                <!-- Color accent bar -->
                <div class="h-1 w-full" :class="eduBarGradients[index % eduBarGradients.length]"></div>

                <div class="p-6 lg:p-7">
                  <!-- Header -->
                  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                    <div class="flex-1">
                      <h3 class="text-xl font-bold text-white group-hover:text-[#00ff88] transition-colors">
                        {{ edu.degree }}<span v-if="edu.field_of_study" class="text-gray-500 font-normal"> in </span>{{ edu.field_of_study }}
                      </h3>
                      <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1.5">
                        <span class="text-gray-400 font-semibold text-sm flex items-center gap-1.5">
                          <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                          {{ edu.institution_name }}
                        </span>
                        <span v-if="edu.location" class="text-gray-500 text-sm flex items-center gap-1">
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                          {{ edu.location }}
                        </span>
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                      <span v-if="edu.is_current" class="text-[11px] font-bold text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-[#00ff88] rounded-full animate-pulse"></span>
                        In Progress
                      </span>
                      <span class="text-xs font-medium text-gray-400 bg-[#1a1a1a] px-3 py-1.5 rounded-full whitespace-nowrap border border-[#1f1f1f]">
                        {{ formatDate(edu.start_date) }} — {{ edu.is_current ? 'Present' : formatDate(edu.end_date) }}
                      </span>
                    </div>
                  </div>

                  <!-- Duration -->
                  <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      {{ getDuration(edu.start_date, edu.end_date, edu.is_current) }}
                    </span>
                  </div>

                  <!-- Grade -->
                  <div v-if="edu.grade" class="mb-4">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#00ff88] bg-[#00ff88]/10 px-3.5 py-1.5 rounded-xl border border-[#00ff88]/20">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                      {{ edu.grade }}
                    </span>
                  </div>

                  <!-- Description -->
                  <p v-if="edu.description" class="text-gray-400 text-sm leading-relaxed mb-5">{{ edu.description }}</p>

                  <!-- Achievements -->
                  <div v-if="edu.achievements?.length">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Notable Achievements</h4>
                    <ul class="space-y-2.5">
                      <li v-for="(a, ai) in edu.achievements" :key="ai" class="flex items-start gap-2.5 text-sm text-gray-400">
                        <div class="w-5 h-5 rounded-full bg-[#00ff88]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-3 h-3 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" /></svg>
                        </div>
                        <span>{{ a }}</span>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State for Education -->
        <div v-if="!education?.length" class="text-center py-20">
          <div class="w-20 h-20 bg-[#00ff88]/10 rounded-3xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-2">No Education Added Yet</h3>
          <p class="text-gray-400 max-w-sm mx-auto text-sm">Education entries will appear here once added through the admin panel.</p>
        </div>
      </div>

      <!-- Certifications Section -->
      <div v-if="certifications?.length" style="background-color: #0a0a0a;">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
          <div class="text-center mb-12">
            <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
              <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
              Professional Certifications
              <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            </h2>
            <p class="text-gray-400 text-sm max-w-lg mx-auto">Industry-recognized credentials that validate my expertise.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div v-for="(cert, ci) in certifications" :key="cert.id"
                 class="group rounded-2xl border border-[#1f1f1f] shadow-sm hover:shadow-xl hover:border-[#00ff88]/20 transition-all duration-500 overflow-hidden" style="background-color: #111;">
              <!-- Accent bar -->
              <div class="h-1 w-full" :class="certBarGradients[ci % certBarGradients.length]"></div>

              <div class="p-6">
                <div class="flex items-start gap-4">
                  <!-- Badge Icon -->
                  <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110"
                       :class="certIconBg[ci % certIconBg.length]">
                    <svg class="w-7 h-7" :class="certIconColor[ci % certIconColor.length]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                  </div>

                  <!-- Content -->
                  <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-white group-hover:text-[#00ff88] transition-colors leading-snug">{{ cert.name }}</h4>
                    <div class="text-sm text-gray-400 font-medium mt-1">{{ cert.issuing_organization }}</div>

                    <!-- Dates & Status -->
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                      <span class="text-xs text-gray-400 bg-[#1a1a1a] px-2.5 py-1 rounded-full border border-[#1f1f1f]">
                        Issued {{ formatDate(cert.issue_date) }}
                      </span>
                      <span v-if="cert.expiry_date && new Date(cert.expiry_date) > new Date()" class="text-xs text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full border border-[#00ff88]/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-[#00ff88] rounded-full"></span>
                        Valid
                      </span>
                      <span v-else-if="cert.expiry_date && new Date(cert.expiry_date) <= new Date()" class="text-xs text-gray-400 bg-[#1a1a1a] px-2.5 py-1 rounded-full border border-[#1f1f1f]">
                        Expired {{ formatDate(cert.expiry_date) }}
                      </span>
                      <span v-else-if="!cert.expiry_date" class="text-xs text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full border border-[#00ff88]/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-[#00ff88] rounded-full"></span>
                        No Expiry
                      </span>
                    </div>

                    <!-- Credential ID -->
                    <div v-if="cert.credential_id" class="mt-3">
                      <span class="text-xs text-gray-500">ID: <span class="font-mono text-gray-400">{{ cert.credential_id }}</span></span>
                    </div>

                    <!-- Description -->
                    <p v-if="cert.description" class="text-sm text-gray-400 mt-3 leading-relaxed">{{ cert.description }}</p>

                    <!-- Credential Link -->
                    <a v-if="cert.credential_url" :href="cert.credential_url" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 text-sm text-[#00ff88] hover:text-[#00ff88] mt-3 font-semibold group/link transition-colors">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                      Verify Credential
                      <svg class="w-3 h-3 opacity-0 -translate-x-1 group-hover/link:opacity-100 group-hover/link:translate-x-0 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- CTA Section -->
      <div v-if="education?.length || certifications?.length" style="background-color: #0a0a0a;">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
          <h2 class="text-2xl font-black text-white mb-3">Want to see my full qualifications?</h2>
          <p class="text-gray-400 mb-8 max-w-lg mx-auto">Download my resume for a comprehensive overview of my education, certifications, and experience.</p>
          <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link :href="route('resume.create')"
                  class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-[#00cc6a] transition-all shadow-lg shadow-[#00ff88]/25 hover:shadow-xl hover:shadow-[#00ff88]/30 hover:-translate-y-0.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              Download Resume
            </Link>
            <Link :href="route('portfolio.contact')"
                  class="inline-flex items-center gap-2 bg-white/5 text-white px-7 py-3.5 rounded-xl text-sm font-bold border border-white/10 hover:bg-white/10 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
              Get in Touch
            </Link>
          </div>
        </div>
      </div>
    </section>
  </PortfolioLayout>
</template>

<script setup>
import PortfolioLayout from '@/Layouts/PortfolioLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
  meta: Object,
  education: Array,
  certifications: Array,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

// Stats
const totalInstitutions = computed(() => {
  if (!props.education) return 0;
  return new Set(props.education.map(e => e.institution_name)).size;
});

const totalAchievements = computed(() => {
  let count = 0;
  props.education?.forEach(e => { count += e.achievements?.length || 0; });
  return count;
});

// Duration calculator
const getDuration = (start, end, isCurrent) => {
  if (!start) return '';
  const s = new Date(start);
  const e = isCurrent ? new Date() : (end ? new Date(end) : new Date());
  let months = (e.getFullYear() - s.getFullYear()) * 12 + (e.getMonth() - s.getMonth());
  if (months < 0) months = 0;
  const years = Math.floor(months / 12);
  const remaining = months % 12;
  if (years > 0 && remaining > 0) return `${years} yr${years > 1 ? 's' : ''} ${remaining} mo${remaining > 1 ? 's' : ''}`;
  if (years > 0) return `${years} yr${years > 1 ? 's' : ''}`;
  return `${remaining || 1} mo${remaining > 1 ? 's' : ''}`;
};

// Visual variety
const eduNodeColors = ['bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]'];
const eduBarGradients = [
  'bg-gradient-to-r from-[#00ff88] to-[#00cc6a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00ff88] to-[#00e07a]',
  'bg-gradient-to-r from-[#00e07a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00e07a]',
];

const certBarGradients = [
  'bg-gradient-to-r from-[#00ff88] to-[#00cc6a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00e07a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00ff88] to-[#00e07a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00e07a]',
  'bg-gradient-to-r from-[#00e07a] to-[#00cc6a]',
];
const certIconBg = ['bg-[#00ff88]/10', 'bg-[#00ff88]/10', 'bg-[#00ff88]/10', 'bg-[#00ff88]/10', 'bg-[#00ff88]/10', 'bg-[#00ff88]/10'];
const certIconColor = ['text-[#00ff88]', 'text-[#00ff88]', 'text-[#00ff88]', 'text-[#00ff88]', 'text-[#00ff88]', 'text-[#00ff88]'];
</script>
