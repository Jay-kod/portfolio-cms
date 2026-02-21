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
      <div class="absolute inset-0" style="background-image: linear-gradient(rgba(0,255,136,0.06) 2px, transparent 2px), linear-gradient(90deg, rgba(0,255,136,0.06) 2px, transparent 2px), linear-gradient(rgba(0,255,136,0.03) 1px, transparent 1px), linear-gradient(90deg, rgba(0,255,136,0.03) 1px, transparent 1px); background-size: 80px 80px, 80px 80px, 16px 16px, 16px 16px;"></div>
      <!-- Floating accents -->
      <div class="absolute top-20 left-10 w-24 h-24 bg-[#00ff88]/10 rounded-full blur-2xl animate-pulse"></div>
      <div class="absolute bottom-10 right-16 w-36 h-36 bg-[#00ff88]/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-white/5 backdrop-blur-md rounded-3xl mb-6 border border-[#00ff88]/20 shadow-2xl shadow-[#00ff88]/10">
          <svg class="w-12 h-12 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Experience & Education</h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">My professional journey, academic background, and the qualifications that shaped my career.</p>
      </div>
    </section>

    <!-- Stats Banner -->
    <section class="bg-[#0a0a0a] -mt-6 relative z-10 rounded-t-3xl">
      <div class="border-b border-[#1f1f1f]" style="background: linear-gradient(135deg, rgba(0,255,136,0.03) 0%, transparent 50%, rgba(0,255,136,0.02) 100%);">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
          <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ totalYears }}+</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Years Exp</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ experiences?.length || 0 }}</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Positions</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ totalCompanies }}</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Companies</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ totalTechnologies }}+</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Technologies</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ education?.length || 0 }}</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Degrees</div>
            </div>
            <div class="rounded-2xl p-5 text-center border border-[#1f1f1f] bg-[#111] hover:-translate-y-1 transition-all duration-300">
              <div class="text-3xl font-black text-[#00ff88] mb-1">{{ certifications?.length || 0 }}</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Certifications</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Current Role Spotlight -->
      <div v-if="currentRole" class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div class="text-center mb-8">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            Current Role
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
          </h2>
        </div>
        <div class="bg-[#111] rounded-3xl border border-[#1f1f1f] overflow-hidden hover:border-[#00ff88]/20 transition-all duration-500 group">
          <div class="grid grid-cols-1 lg:grid-cols-5">
            <!-- Left accent -->
            <div class="lg:col-span-2 p-8 lg:p-10 flex flex-col items-center justify-center relative overflow-hidden" style="background: linear-gradient(135deg, rgba(0,255,136,0.08), rgba(0,255,136,0.03), rgba(0,255,136,0.06));">
              <div class="absolute -top-10 -right-10 w-40 h-40 bg-[#00ff88]/10 rounded-full blur-2xl"></div>
              <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-[#00ff88]/5 rounded-full blur-2xl"></div>
              <div class="relative">
                <div class="w-20 h-20 rounded-3xl bg-[#00ff88]/10 backdrop-blur-sm flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-500">
                  <svg class="w-10 h-10 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-[#00ff88] font-bold text-lg text-center">{{ currentRole.company_name }}</p>
                <p class="text-[#00ff88]/70 text-sm text-center mt-1">{{ currentRole.company_location }}</p>
                <div class="mt-4 flex items-center justify-center gap-2">
                  <span class="w-2 h-2 bg-[#00ff88] rounded-full animate-pulse"></span>
                  <span class="text-[#00ff88] text-xs font-bold uppercase tracking-wider">Currently Active</span>
                </div>
              </div>
            </div>
            <!-- Right content -->
            <div class="lg:col-span-3 p-8 lg:p-10 flex flex-col justify-center">
              <div class="flex flex-wrap items-center gap-3 mb-4">
                <span v-if="currentRole.employment_type" class="inline-flex items-center gap-1.5 bg-[#00ff88]/10 text-[#00ff88] px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase">
                  {{ currentRole.employment_type }}
                </span>
                <span class="text-sm text-gray-500">{{ formatDate(currentRole.start_date) }} — Present</span>
              </div>
              <h3 class="text-2xl lg:text-3xl font-black text-white mb-3 group-hover:text-[#00ff88] transition">{{ currentRole.job_title }}</h3>
              <p class="text-gray-400 leading-relaxed mb-5">{{ currentRole.description }}</p>
              <!-- Achievements -->
              <div v-if="currentRole.achievements?.length" class="space-y-2.5 mb-6">
                <div v-for="(a, i) in currentRole.achievements" :key="i"
                     class="flex items-start gap-3 text-sm text-gray-400">
                  <div class="w-5 h-5 rounded-full bg-[#00ff88]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <svg class="w-3 h-3 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                  </div>
                  <span>{{ a }}</span>
                </div>
              </div>
              <!-- Tech stack -->
              <div v-if="currentRole.technologies_used?.length" class="flex flex-wrap gap-2">
                <span v-for="tech in currentRole.technologies_used" :key="tech"
                      class="text-xs bg-[#00ff88]/10 text-[#00ff88] px-3 py-1.5 rounded-lg font-semibold border border-[#00ff88]/20">
                  {{ tech }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Career Timeline -->
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-20" :class="currentRole ? 'pt-4' : 'pt-14'">
        <div class="text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-gray-500 uppercase mb-3 flex items-center justify-center gap-2">
            <span class="w-8 h-0.5 bg-gradient-to-r from-[#00ff88]/50 to-[#00ff88]/20 rounded-full"></span>
            Career Timeline
            <span class="w-8 h-0.5 bg-gradient-to-r from-[#00ff88]/20 to-[#00ff88]/50 rounded-full"></span>
          </h2>
          <p class="text-gray-400 text-sm max-w-lg mx-auto">Roles and responsibilities that have shaped my professional growth.</p>
        </div>

        <div v-if="pastExperiences.length" class="relative">
          <!-- Timeline line -->
          <div class="absolute left-6 md:left-1/2 md:-translate-x-px top-0 bottom-0 w-0.5 bg-gradient-to-b from-[#00ff88] via-[#1f1f1f] to-transparent"></div>

          <div v-for="(exp, index) in pastExperiences" :key="exp.id"
               class="relative mb-12 last:mb-0"
               :class="index % 2 === 0 ? 'md:pr-[calc(50%+2rem)]' : 'md:pl-[calc(50%+2rem)]'">

            <!-- Timeline node -->
            <div class="absolute left-6 md:left-1/2 -translate-x-1/2 top-8 z-10">
              <div class="w-4 h-4 rounded-full border-[3px] border-[#0a0a0a] shadow-md"
                   :class="getNodeColor(index)">
              </div>
            </div>

            <!-- Connector line (mobile only) -->
            <div class="absolute left-6 top-8 w-6 h-px bg-[#1f1f1f] md:hidden"></div>

            <!-- Card -->
            <div class="ml-16 md:ml-0 group">
              <div class="bg-[#111] rounded-2xl border border-[#1f1f1f] hover:border-[#00ff88]/30 transition-all duration-500 overflow-hidden">
                <!-- Color accent bar -->
                <div class="h-1 w-full" :class="getBarGradient(index)"></div>

                <div class="p-6 lg:p-7">
                  <!-- Header -->
                  <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-3 mb-4">
                    <div class="flex-1">
                      <h3 class="text-xl font-bold text-white group-hover:text-[#00ff88] transition-colors">{{ exp.job_title }}</h3>
                      <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1.5">
                        <span class="text-gray-400 font-semibold text-sm flex items-center gap-1.5">
                          <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                          {{ exp.company_name }}
                        </span>
                        <span v-if="exp.company_location" class="text-gray-500 text-sm flex items-center gap-1">
                          <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                          {{ exp.company_location }}
                        </span>
                      </div>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                      <span v-if="exp.employment_type" class="text-[11px] font-bold text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full uppercase tracking-wider">
                        {{ exp.employment_type }}
                      </span>
                      <span class="text-xs font-medium text-gray-500 bg-[#1a1a1a] px-3 py-1.5 rounded-full whitespace-nowrap border border-[#1f1f1f]">
                        {{ formatDate(exp.start_date) }} — {{ exp.is_current ? 'Present' : formatDate(exp.end_date) }}
                      </span>
                    </div>
                  </div>

                  <!-- Duration badge -->
                  <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      {{ getDuration(exp.start_date, exp.end_date, exp.is_current) }}
                    </span>
                  </div>

                  <!-- Description -->
                  <p v-if="exp.description" class="text-gray-400 text-sm leading-relaxed mb-5">{{ exp.description }}</p>

                  <!-- Achievements -->
                  <div v-if="exp.achievements?.length" class="mb-5">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-3">Key Achievements</h4>
                    <ul class="space-y-2.5">
                      <li v-for="(a, ai) in exp.achievements" :key="ai" class="flex items-start gap-2.5 text-sm text-gray-400">
                        <div class="w-5 h-5 rounded-full bg-[#00ff88]/10 flex items-center justify-center flex-shrink-0 mt-0.5">
                          <svg class="w-3 h-3 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" /></svg>
                        </div>
                        <span>{{ a }}</span>
                      </li>
                    </ul>
                  </div>

                  <!-- Technologies -->
                  <div v-if="exp.technologies_used?.length">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-gray-500 mb-2.5">Tech Stack</h4>
                    <div class="flex flex-wrap gap-1.5">
                      <span v-for="tech in exp.technologies_used" :key="tech"
                            class="text-xs font-medium px-2.5 py-1 rounded-lg border transition-colors"
                            :class="getTechClasses(index)">
                        {{ tech }}
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!experiences?.length" class="text-center py-20">
          <div class="w-20 h-20 bg-[#1a1a1a] rounded-3xl flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-2">No Experience Added Yet</h3>
          <p class="text-gray-500 max-w-sm mx-auto text-sm">Professional experience entries will appear here once added through the admin panel.</p>
        </div>
      </div>

      <!-- ═══════════════════════════════════════════ -->
      <!-- Academic Degrees Section -->
      <!-- ═══════════════════════════════════════════ -->
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14 border-t border-[#1f1f1f]">
        <div class="text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            Academic Background
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
          </h2>
          <p class="text-3xl font-black text-white mb-3">Education</p>
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
                   :class="edu.is_current ? 'bg-[#00ff88]' : 'bg-[#00ff88]'"></div>
            </div>
            <!-- Card -->
            <div class="ml-16 md:ml-0 group">
              <div class="rounded-2xl border border-[#1f1f1f] shadow-sm hover:shadow-xl hover:border-[#00ff88]/20 transition-all duration-500 overflow-hidden bg-[#111]">
                <div class="h-1 w-full bg-gradient-to-r from-[#00ff88] to-[#00cc6a]"></div>
                <div class="p-6 lg:p-7">
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
                  <div class="mb-4">
                    <span class="inline-flex items-center gap-1.5 text-xs text-gray-500">
                      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                      {{ getDuration(edu.start_date, edu.end_date, edu.is_current) }}
                    </span>
                  </div>
                  <div v-if="edu.grade" class="mb-4">
                    <span class="inline-flex items-center gap-2 text-sm font-semibold text-[#00ff88] bg-[#00ff88]/10 px-3.5 py-1.5 rounded-xl border border-[#00ff88]/20">
                      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                      {{ edu.grade }}
                    </span>
                  </div>
                  <p v-if="edu.description" class="text-gray-400 text-sm leading-relaxed mb-5">{{ edu.description }}</p>
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

        <div v-if="!education?.length" class="text-center py-16">
          <div class="w-16 h-16 bg-[#1a1a1a] rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5zM12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
          </div>
          <h3 class="text-lg font-bold text-white mb-2">No Education Added Yet</h3>
          <p class="text-gray-400 max-w-sm mx-auto text-sm">Education entries will appear here once added.</p>
        </div>
      </div>

      <!-- ═══════════════════════════════════════════ -->
      <!-- Certifications Section -->
      <!-- ═══════════════════════════════════════════ -->
      <div v-if="certifications?.length" class="border-t border-[#1f1f1f]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
          <div class="text-center mb-12">
            <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
              <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
              Professional Certifications
              <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            </h2>
            <p class="text-gray-400 text-sm max-w-lg mx-auto">Industry-recognized credentials that validate my expertise.</p>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div v-for="cert in certifications" :key="cert.id"
                 class="group rounded-2xl border border-[#1f1f1f] shadow-sm hover:shadow-xl hover:border-[#00ff88]/20 transition-all duration-500 overflow-hidden bg-[#111]">
              <div class="h-1 w-full bg-gradient-to-r from-[#00ff88] to-[#00cc6a]"></div>
              <div class="p-6">
                <div class="flex items-start gap-4">
                  <div class="w-14 h-14 rounded-2xl bg-[#00ff88]/10 flex items-center justify-center flex-shrink-0 shadow-sm transition-transform duration-300 group-hover:scale-110">
                    <svg class="w-7 h-7 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
                  </div>
                  <div class="flex-1 min-w-0">
                    <h4 class="font-bold text-white group-hover:text-[#00ff88] transition-colors leading-snug">{{ cert.name }}</h4>
                    <div class="text-sm text-gray-400 font-medium mt-1">{{ cert.issuing_organization }}</div>
                    <div class="flex flex-wrap items-center gap-2 mt-3">
                      <span class="text-xs text-gray-400 bg-[#1a1a1a] px-2.5 py-1 rounded-full border border-[#1f1f1f]">
                        Issued {{ formatDate(cert.issue_date) }}
                      </span>
                      <span v-if="cert.expiry_date && new Date(cert.expiry_date) > new Date()" class="text-xs text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full border border-[#00ff88]/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-[#00ff88] rounded-full"></span> Valid
                      </span>
                      <span v-else-if="cert.expiry_date && new Date(cert.expiry_date) <= new Date()" class="text-xs text-gray-400 bg-[#1a1a1a] px-2.5 py-1 rounded-full border border-[#1f1f1f]">
                        Expired {{ formatDate(cert.expiry_date) }}
                      </span>
                      <span v-else-if="!cert.expiry_date" class="text-xs text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full border border-[#00ff88]/20 flex items-center gap-1">
                        <span class="w-1.5 h-1.5 bg-[#00ff88] rounded-full"></span> No Expiry
                      </span>
                    </div>
                    <div v-if="cert.credential_id" class="mt-3">
                      <span class="text-xs text-gray-500">ID: <span class="font-mono text-gray-400">{{ cert.credential_id }}</span></span>
                    </div>
                    <p v-if="cert.description" class="text-sm text-gray-400 mt-3 leading-relaxed">{{ cert.description }}</p>
                    <a v-if="cert.credential_url" :href="cert.credential_url" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 text-sm text-[#00ff88] hover:text-[#00cc6a] mt-3 font-semibold group/link transition-colors">
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
      <div v-if="experiences?.length || education?.length" style="background: linear-gradient(to top, rgba(0,255,136,0.03), transparent);">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center">
          <h2 class="text-2xl font-black text-white mb-3">Interested in working together?</h2>
          <p class="text-gray-400 mb-8 max-w-lg mx-auto">I'm always open to discussing new opportunities and exciting projects.</p>
          <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
            <Link :href="route('portfolio.contact')"
                  class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-[#00ff88]/90 transition-all shadow-lg shadow-[#00ff88]/25 hover:shadow-xl hover:shadow-[#00ff88]/30 hover:-translate-y-0.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
              Get in Touch
            </Link>
            <Link :href="route('resume.create')"
                  class="inline-flex items-center gap-2 bg-[#00ff88]/20 text-[#00ff88] border border-[#00ff88]/30 px-7 py-3.5 rounded-xl text-sm font-bold hover:bg-[#00ff88]/30 transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              Download Resume
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
  experiences: Array,
  education: Array,
  certifications: Array,
});

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

// Current role (first one marked is_current)
const currentRole = computed(() => {
  return props.experiences?.find(e => e.is_current) || null;
});

// Past experiences (excludes current role)
const pastExperiences = computed(() => {
  if (!props.experiences) return [];
  return props.experiences.filter(e => !e.is_current);
});

// Stats
const totalYears = computed(() => {
  if (!props.experiences?.length) return 0;
  const dates = props.experiences.map(e => new Date(e.start_date));
  const earliest = new Date(Math.min(...dates));
  return Math.floor((Date.now() - earliest.getTime()) / (365.25 * 24 * 60 * 60 * 1000));
});

const totalCompanies = computed(() => {
  if (!props.experiences) return 0;
  return new Set(props.experiences.map(e => e.company_name)).size;
});

const totalTechnologies = computed(() => {
  if (!props.experiences) return 0;
  const techs = new Set();
  props.experiences.forEach(e => {
    e.technologies_used?.forEach(t => techs.add(t));
  });
  return techs.size;
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

// Visual variety for timeline nodes
const nodeColors = ['bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]', 'bg-[#00ff88]'];
const barGradients = [
  'bg-gradient-to-r from-[#00ff88] to-[#00cc6a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00ff88] to-[#00cc6a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00ff88]',
  'bg-gradient-to-r from-[#00ff88] to-[#00cc6a]',
  'bg-gradient-to-r from-[#00cc6a] to-[#00ff88]',
];
const techVariants = [
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
  'bg-[#00ff88]/10 text-[#00ff88] border-[#00ff88]/20',
];

const getNodeColor = (index) => nodeColors[index % nodeColors.length];
const getBarGradient = (index) => barGradients[index % barGradients.length];
const getTechClasses = (index) => techVariants[index % techVariants.length];
</script>
