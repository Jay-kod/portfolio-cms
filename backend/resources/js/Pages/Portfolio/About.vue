<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- About Me Hero -->
    <section class="relative pt-32 pb-20 overflow-hidden">
      <div class="absolute inset-0 bg-[#0a0a0a]"></div>
      <div class="absolute inset-0" style="background-image: repeating-radial-gradient(circle at 20% 50%, transparent 0, transparent 30px, rgba(0,255,136,0.04) 31px, transparent 32px), repeating-radial-gradient(circle at 80% 30%, transparent 0, transparent 25px, rgba(0,255,136,0.03) 26px, transparent 27px), repeating-radial-gradient(circle at 50% 90%, transparent 0, transparent 45px, rgba(0,255,136,0.02) 46px, transparent 47px);"></div>
      <!-- Accent glow -->
      <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-96 h-96 bg-[#00ff88]/5 rounded-full blur-[120px] pointer-events-none"></div>

      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
          <!-- Left: Profile Image -->
          <div class="flex justify-center lg:justify-start">
            <div class="about-image-wrapper relative">
              <!-- Decorative arc -->
              <svg class="about-arc absolute -inset-5 w-[calc(100%+40px)] h-[calc(100%+40px)]" viewBox="0 0 340 340" fill="none">
                <circle cx="170" cy="170" r="155" stroke="url(#arcGradAbout)" stroke-width="2.5" stroke-dasharray="6 8" stroke-linecap="round" opacity="0.6"/>
                <defs>
                  <linearGradient id="arcGradAbout" x1="0" y1="0" x2="340" y2="340">
                    <stop offset="0%" stop-color="#00ff88"/>
                    <stop offset="50%" stop-color="#00cc6a"/>
                    <stop offset="100%" stop-color="transparent"/>
                  </linearGradient>
                </defs>
              </svg>
              <!-- Orbiting dots (planets) -->
              <div class="orbit orbit-1"><div class="orbit-dot orbit-dot-lg"></div></div>
              <div class="orbit orbit-2"><div class="orbit-dot orbit-dot-md"></div></div>
              <div class="orbit orbit-3"><div class="orbit-dot orbit-dot-sm"></div></div>
              <div class="orbit orbit-4"><div class="orbit-dot orbit-dot-xs"></div></div>

              <!-- Main circle -->
              <div class="about-image-circle relative w-64 h-64 sm:w-72 sm:h-72 rounded-full overflow-hidden border-2 border-[#1f1f1f] shadow-2xl shadow-[#00ff88]/10">
                <img v-if="profileImage" :src="profileImage" alt="Profile" class="w-full h-full object-cover" />
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#111] via-[#0a0a0a] to-[#111]">
                  <div class="text-center">
                    <span class="text-6xl sm:text-7xl font-black bg-gradient-to-br from-[#00ff88] to-[#00cc6a] bg-clip-text text-transparent leading-none">{{ siteIconLetter }}</span>
                    <div class="mt-2 text-xs font-bold tracking-[0.3em] text-gray-600 uppercase">Developer</div>
                  </div>
                </div>
                <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/5"></div>
              </div>
            </div>
          </div>

          <!-- Right: About Content -->
          <div class="text-center lg:text-left">
            <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 text-[#00ff88] px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-[#00ff88]/20">
              <span class="text-sm">👋</span>
              Hi There!
            </div>

            <h1 class="text-4xl sm:text-5xl font-black text-white mb-3 leading-tight">
              I'm <span class="text-[#00ff88]">{{ displayName }}</span>
            </h1>

            <!-- Role tagline -->
            <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-6">
              <span v-for="(role, i) in roles" :key="i"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-sm font-bold border"
                    :class="i === 0 ? 'bg-[#00ff88]/15 text-[#00ff88] border-[#00ff88]/30' : 'bg-[#111] text-gray-300 border-[#1f1f1f]'">
                {{ role }}
              </span>
            </div>

            <p v-if="bio" class="text-gray-400 leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
              {{ truncatedBio }}
            </p>

            <!-- Quick Stats inline -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-8">
              <div v-for="stat in heroStats" :key="stat.label" class="text-center lg:text-left">
                <div class="text-2xl sm:text-3xl font-black" :class="stat.valueClass">{{ stat.value }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ stat.label }}</div>
              </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
              <Link :href="route('portfolio.contact')"
                    class="inline-flex items-center justify-center gap-2 bg-[#00ff88] text-black px-7 py-3.5 rounded-2xl font-bold hover:bg-[#00cc6a] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                Get In Touch
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
              </Link>
              <Link :href="route('resume.create')"
                    class="inline-flex items-center justify-center gap-2 border-2 border-[#1f1f1f] text-white px-7 py-3.5 rounded-2xl font-bold hover:bg-white/5 hover:border-[#00ff88]/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Get My Resume
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content -->
    <section class="bg-[#0a0a0a] -mt-6 relative z-10 rounded-t-3xl">
      <!-- Mission & Vision -->
      <div class="bg-[#111] border-b border-[#1f1f1f]">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 md:py-14">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <!-- Mission -->
            <div v-if="objective" class="text-center md:text-left">
              <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 text-[#00ff88] px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                My Mission
              </div>
              <p class="text-lg md:text-xl font-bold text-white leading-relaxed">{{ objective.content }}</p>
            </div>
            <!-- Vision -->
            <div v-if="vision" class="text-center md:text-left md:border-l md:border-[#1f1f1f] md:pl-12">
              <div class="inline-flex items-center gap-2 bg-amber-500/10 text-amber-400 px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-5">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                My Vision
              </div>
              <p class="text-lg md:text-xl font-bold text-white leading-relaxed">{{ vision.content }}</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Two-column Bio + Stats layout -->
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-12 lg:gap-16">
          <!-- Left: Bio story (3 cols wide) -->
          <div class="lg:col-span-3 space-y-8">
            <div>
              <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-4 flex items-center gap-2">
                <span class="w-8 h-0.5 bg-gradient-to-r from-[#00ff88] to-[#00cc6a] rounded-full"></span>
                Who I Am
              </h2>
              <div v-if="bio" class="text-lg text-gray-400 leading-[1.8] space-y-5">
                <p>{{ bio.content }}</p>
              </div>
            </div>

            <!-- What I Do - highlights -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
              <div v-for="highlight in highlights" :key="highlight.title"
                   class="bg-[#111] rounded-2xl p-5 border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:shadow-md hover:shadow-[#00ff88]/5 transition-all duration-300 group">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3 shadow-sm"
                     :class="highlight.iconBg">
                  <span class="text-lg">{{ highlight.emoji }}</span>
                </div>
                <h3 class="font-bold text-white mb-1 group-hover:text-[#00ff88] transition">{{ highlight.title }}</h3>
                <p class="text-sm text-gray-500 leading-relaxed">{{ highlight.desc }}</p>
              </div>
            </div>

            <!-- Extra profile sections -->
            <div v-for="section in otherSections" :key="section.id" class="pt-4">
              <h3 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center gap-2">
                <span class="w-6 h-0.5 bg-gradient-to-r from-[#00ff88] to-[#00cc6a] rounded-full"></span>
                {{ section.section_name.replace('_', ' ') }}
              </h3>
              <p class="text-gray-400 leading-relaxed text-lg">{{ section.content }}</p>
            </div>
          </div>

          <!-- Right: Stats + Quick facts sidebar (2 cols wide) -->
          <div class="lg:col-span-2 space-y-6">
            <!-- Stats cards -->
            <div class="grid grid-cols-2 gap-3">
              <div v-for="(stat, i) in stats" :key="stat.label"
                   class="stat-card rounded-2xl p-5 text-center border transition-all duration-300 hover:-translate-y-1"
                   :class="stat.classes">
                <div class="text-3xl font-black mb-1" :class="stat.valueClass">{{ stat.value }}</div>
                <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ stat.label }}</div>
              </div>
            </div>

            <!-- Quick facts card -->
            <div class="bg-[#111] rounded-2xl p-6 text-white shadow-xl border border-[#1f1f1f]">
              <h3 class="text-xs font-bold tracking-widest text-[#00ff88] uppercase mb-5">Quick Facts</h3>
              <div class="space-y-4">
                <div v-for="fact in quickFacts" :key="fact.label" class="flex items-start gap-3">
                  <div class="w-8 h-8 rounded-lg bg-[#00ff88]/10 flex items-center justify-center shrink-0 mt-0.5">
                    <span class="text-sm">{{ fact.emoji }}</span>
                  </div>
                  <div class="min-w-0">
                    <div class="text-xs text-gray-500 font-medium">{{ fact.label }}</div>
                    <div class="text-sm font-semibold text-white">{{ fact.value }}</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Top skills mini-preview -->
            <div class="bg-[#111] rounded-2xl p-6 border border-[#1f1f1f]">
              <h3 class="text-xs font-bold tracking-widest text-gray-500 uppercase mb-4">Top Technologies</h3>
              <div class="flex flex-wrap gap-2">
                <span v-for="skill in topSkills" :key="skill.id"
                      class="inline-flex items-center gap-1.5 bg-[#00ff88]/10 text-[#00ff88] px-3 py-1.5 rounded-lg text-xs font-semibold border border-[#00ff88]/20">
                  <span class="w-1.5 h-1.5 rounded-full bg-[#00ff88]"></span>
                  {{ skill.name }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Skills & Technologies -->
    <section class="py-20 bg-[#0a0a0a] border-t border-[#1f1f1f]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 text-[#00ff88] px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-4">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
            Tech Stack
          </div>
          <h2 class="text-3xl font-black text-white mb-3">Skills & Technologies</h2>
          <p class="text-gray-400 max-w-2xl mx-auto">A comprehensive look at the technologies, tools, and frameworks I work with.</p>
        </div>

        <!-- Quick overview pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-14">
          <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border font-semibold text-sm" style="background-color: rgba(0,255,136,0.1); color: #00ff88; border-color: rgba(0,255,136,0.2);">
            <span class="text-lg">🚀</span> {{ skills?.length || 0 }} Technologies
          </div>
          <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border font-semibold text-sm" style="background-color: rgba(0,255,136,0.05); color: #9ca3af; border-color: #1f1f1f;">
            <span class="text-lg">📂</span> {{ Object.keys(groupedSkills).length }} Categories
          </div>
        </div>

        <!-- Category Blocks -->
        <div class="space-y-14">
          <div v-for="(categorySkills, category) in groupedSkills" :key="category" class="group/cat">
            <!-- Category Header -->
            <div class="flex items-center gap-5 mb-6">
              <div class="cat-icon-3d shrink-0" :class="categoryMeta[category]?.iconClass || 'cat-icon-default'">
                <div class="cat-icon-face">
                  <span class="text-2xl" v-html="categoryMeta[category]?.icon || '💡'"></span>
                </div>
              </div>
              <div>
                <h3 class="text-2xl font-black text-white">{{ category }}</h3>
                <p class="text-sm text-gray-500 mt-0.5">{{ categoryMeta[category]?.subtitle || `${categorySkills.length} technologies` }}</p>
              </div>
            </div>
            <!-- Tech Pills -->
            <div class="flex flex-wrap gap-3">
              <div v-for="skill in categorySkills" :key="skill.id"
                   class="tech-pill group cursor-default"
                   :class="categoryMeta[category]?.pillClass || 'pill-default'">
                <div class="tech-icon-mini" :class="!hasIcon(skill.name) ? (categoryMeta[category]?.iconBgClass || 'icon-bg-default') : ''">
                  <img v-if="hasIcon(skill.name)" :src="getIconUrl(skill.name)" :alt="skill.name"
                       class="w-[18px] h-[18px] object-contain" @error="(e) => onIconError(skill.name, e)" loading="lazy" />
                  <span v-if="!hasIcon(skill.name)" class="text-[10px] font-black text-white leading-none">{{ skill.name[0] }}</span>
                </div>
                <span class="font-semibold text-sm text-gray-300 group-hover:text-white transition">{{ skill.name }}</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Journey Timeline -->
    <section class="py-20 bg-[#0a0a0a]">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3">My Journey</h2>
          <p class="text-3xl font-black text-white">Career & Education</p>
        </div>

        <div class="relative">
          <!-- Vertical line -->
          <div class="absolute left-5 md:left-1/2 top-0 bottom-0 w-px bg-gradient-to-b from-[#00ff88] via-[#00cc6a] to-amber-500 md:-translate-x-px"></div>

          <div class="space-y-10">
            <div v-for="(item, i) in timelineItems" :key="i"
                 class="relative flex items-start gap-6 md:gap-0"
                 :class="i % 2 === 0 ? 'md:flex-row' : 'md:flex-row-reverse'">
              <!-- Dot -->
              <div class="absolute left-5 md:left-1/2 w-3 h-3 rounded-full border-2 border-[#0a0a0a] shadow-md md:-translate-x-1.5 -translate-x-1.5 mt-6 z-10"
                   :class="item.dotColor"></div>
              <!-- Spacer for mobile -->
              <div class="w-10 shrink-0 md:hidden"></div>
              <!-- Card -->
              <div class="flex-1 md:w-[calc(50%-2rem)]"
                   :class="i % 2 === 0 ? 'md:pr-12' : 'md:pl-12'">
                <div class="bg-[#111] rounded-2xl p-6 border border-[#1f1f1f] hover:border-[#00ff88]/20 hover:shadow-lg hover:shadow-[#00ff88]/5 transition-all duration-300 group">
                  <div class="flex items-center gap-2 mb-2">
                    <span class="text-lg">{{ item.emoji }}</span>
                    <span class="text-xs font-bold text-[#00ff88] bg-[#00ff88]/10 px-2.5 py-1 rounded-full">{{ item.period }}</span>
                  </div>
                  <h3 class="text-lg font-bold text-white group-hover:text-[#00ff88] transition">{{ item.title }}</h3>
                  <p class="text-sm text-gray-500 font-medium mt-0.5">{{ item.subtitle }}</p>
                  <p v-if="item.description" class="text-sm text-gray-500 mt-2 leading-relaxed">{{ item.description }}</p>
                </div>
              </div>
              <!-- Hidden spacer for desktop alternating -->
              <div class="hidden md:block md:w-[calc(50%-2rem)]"></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Certifications -->
    <section v-if="certifications?.length" class="py-20 bg-[#0a0a0a]">
      <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-14">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3">Credentials</h2>
          <p class="text-3xl font-black text-white">Certifications & Licenses</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
          <div v-for="cert in certifications" :key="cert.id"
               class="bg-[#111] rounded-2xl p-6 border border-[#1f1f1f] hover:border-[#00ff88]/20 hover:shadow-lg hover:shadow-[#00ff88]/5 transition-all duration-300 group relative overflow-hidden">
            <!-- Accent bar -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00ff88] via-[#00cc6a] to-amber-400 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
            <div class="flex items-start gap-4">
              <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center shrink-0 shadow-sm group-hover:scale-110 transition-transform duration-300">
                <span class="text-2xl">🏅</span>
              </div>
              <div class="min-w-0 flex-1">
                <h3 class="font-bold text-white group-hover:text-[#00ff88] transition text-lg leading-tight">{{ cert.name }}</h3>
                <p class="text-sm text-gray-500 font-medium mt-1">{{ cert.issuing_organization }}</p>
                <div class="flex flex-wrap items-center gap-3 mt-3 text-xs text-gray-500">
                  <span v-if="cert.issue_date" class="inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ formatDate(cert.issue_date) }}
                  </span>
                  <span v-if="cert.expiry_date" class="inline-flex items-center gap-1">
                    → {{ formatDate(cert.expiry_date) }}
                  </span>
                  <span v-if="cert.credential_id" class="text-gray-600 font-mono">
                    ID: {{ cert.credential_id }}
                  </span>
                </div>
                <p v-if="cert.description" class="text-sm text-gray-500 mt-2 leading-relaxed">{{ cert.description }}</p>
                <a v-if="cert.credential_url" :href="cert.credential_url" target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-1.5 text-xs text-[#00ff88] font-semibold mt-3 hover:text-[#00cc6a] transition group/link">
                  Verify Credential
                  <svg class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Explore More CTA -->
    <section class="py-20 bg-[#0a0a0a]">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3">Continue Exploring</h2>
          <p class="text-3xl font-black text-white">See What I've Built</p>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <Link v-for="link in exploreLinks" :key="link.route"
                :href="route(link.route)"
                class="bg-[#111] rounded-2xl p-7 border border-[#1f1f1f] hover:border-[#00ff88]/20 hover:shadow-xl hover:shadow-[#00ff88]/5 transition-all duration-300 text-center group hover:-translate-y-1">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 transition-all duration-300 shadow-sm group-hover:shadow-lg group-hover:scale-110"
                 :class="link.iconBg">
              <span class="text-2xl">{{ link.emoji }}</span>
            </div>
            <h3 class="font-bold text-white group-hover:text-[#00ff88] transition text-lg">{{ link.title }}</h3>
            <p class="text-sm text-gray-500 mt-1.5">{{ link.desc }}</p>
          </Link>
        </div>
      </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-16 bg-[#111] relative overflow-hidden border-t border-b border-[#1f1f1f]">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%2300ff88%22%20fill-opacity%3D%220.03%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-40"></div>
      <div class="absolute -top-32 left-1/2 -translate-x-1/2 w-[500px] h-[300px] rounded-full blur-[100px] pointer-events-none" style="background: rgba(0,255,136,0.06);"></div>
      <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-4">Want to work together?</h2>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto">I'm always open to discussing new projects, creative ideas, or opportunities to be part of your vision.</p>
        <div class="flex flex-wrap justify-center gap-4">
          <Link :href="route('portfolio.contact')"
                class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-8 py-3.5 rounded-2xl font-bold hover:bg-[#00cc6a] transition-all shadow-xl shadow-[#00ff88]/20 hover:shadow-2xl hover:-translate-y-1">
            Get In Touch
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
          <Link :href="route('resume.create')"
                class="inline-flex items-center gap-2 border-2 border-[#1f1f1f] text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-white/5 hover:border-[#00ff88]/30 transition-all">
            Download Resume
          </Link>
        </div>
      </div>
    </section>
  </PortfolioLayout>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import PortfolioLayout from '@/Layouts/PortfolioLayout.vue';
import { useTechIcons } from '@/composables/useTechIcons';

const { getIconUrl, hasIcon, onIconError } = useTechIcons();

const props = defineProps({
  meta: Object,
  profile: Array,
  skills: Array,
  experiences: Array,
  projects: Array,
  certifications: Array,
  education: Array,
});

const siteSettings = computed(() => usePage().props.siteSettings || {});
const siteIconLetter = computed(() => siteSettings.value.site_icon_letter || 'J');
const profileImage = computed(() => siteSettings.value.site_profile_image || '');

const displayName = computed(() => {
  const name = siteSettings.value.site_name || 'Jay';
  return name.replace(/\.\w+$/, '').replace(/\.\s*$/, '');
});

const roles = computed(() => {
  const obj = objective.value?.content || '';
  const firstSentence = obj.split('.')[0] || '';
  const keywords = ['Developer', 'Engineer', 'Designer', 'Architect', 'Specialist', 'Expert', 'Programmer'];
  const found = [];
  keywords.forEach(k => {
    const regex = new RegExp(`\\w+\\s+${k}|${k}`, 'gi');
    const matches = firstSentence.match(regex);
    if (matches) found.push(...matches);
  });
  return found.length > 0 ? found.slice(0, 3) : ['Full Stack Developer'];
});

const truncatedBio = computed(() => {
  const content = bio.value?.content || '';
  if (content.length <= 200) return content;
  return content.substring(0, 200).replace(/\s\S*$/, '') + '...';
});

const heroStats = computed(() => [
  { value: `${maxYears.value}+`, label: 'Years Exp', valueClass: 'text-[#00ff88]' },
  { value: props.projects?.length || 0, label: 'Projects', valueClass: 'text-amber-500' },
  { value: props.skills?.length || 0, label: 'Technologies', valueClass: 'text-emerald-500' },
  { value: props.certifications?.length || 0, label: 'Certs', valueClass: 'text-sky-500' },
]);

const bio = computed(() => props.profile?.find(p => p.section_name === 'bio'));
const objective = computed(() => props.profile?.find(p => p.section_name === 'objective'));
const vision = computed(() => props.profile?.find(p => p.section_name === 'vision'));
const otherSections = computed(() => props.profile?.filter(p => !['bio', 'objective', 'vision', 'highlight', 'quick_fact'].includes(p.section_name)) || []);

const highlights = computed(() => {
  const items = props.profile?.filter(p => p.section_name === 'highlight' && p.is_active) || [];
  return items.map(h => ({
    title: h.title || 'Untitled',
    desc: h.content,
    emoji: h.metadata?.emoji || '✨',
    iconBg: h.metadata?.iconBg || 'bg-[#00ff88]/10',
  }));
});

const quickFacts = computed(() => {
  const items = props.profile?.filter(p => p.section_name === 'quick_fact' && p.is_active) || [];
  return items.map(f => ({
    label: f.title || 'Fact',
    value: f.content,
    emoji: f.metadata?.emoji || '📌',
  }));
});

const topSkills = computed(() => (props.skills || []).slice(0, 12));

const groupedSkills = computed(() => {
  const groups = {};
  const order = ['Backend', 'Frontend', 'Database', 'AI & ML', 'DevOps & Cloud', 'Cybersecurity', 'Automation', 'Design', 'Document Editing', 'Hardware & Software', 'Tools'];
  props.skills?.forEach(s => {
    if (!groups[s.category]) groups[s.category] = [];
    groups[s.category].push(s);
  });
  const sorted = {};
  order.forEach(cat => { if (groups[cat]) sorted[cat] = groups[cat]; });
  Object.keys(groups).forEach(cat => { if (!sorted[cat]) sorted[cat] = groups[cat]; });
  return sorted;
});

const categoryMeta = {
  'Backend': { icon: '⚙️', iconClass: 'cat-icon-violet', subtitle: 'Server-side languages & frameworks', pillClass: 'pill-violet', iconBgClass: 'icon-bg-violet' },
  'Frontend': { icon: '🎨', iconClass: 'cat-icon-sky', subtitle: 'UI frameworks, styling & markup', pillClass: 'pill-sky', iconBgClass: 'icon-bg-sky' },
  'Database': { icon: '🗄️', iconClass: 'cat-icon-emerald', subtitle: 'Data storage & management', pillClass: 'pill-emerald', iconBgClass: 'icon-bg-emerald' },
  'AI & ML': { icon: '🧠', iconClass: 'cat-icon-pink', subtitle: 'Artificial intelligence & intelligent systems', pillClass: 'pill-pink', iconBgClass: 'icon-bg-pink' },
  'DevOps & Cloud': { icon: '☁️', iconClass: 'cat-icon-amber', subtitle: 'Deployment, infrastructure & version control', pillClass: 'pill-amber', iconBgClass: 'icon-bg-amber' },
  'Cybersecurity': { icon: '🛡️', iconClass: 'cat-icon-red', subtitle: 'Security practices & protection', pillClass: 'pill-red', iconBgClass: 'icon-bg-red' },
  'Automation': { icon: '🤖', iconClass: 'cat-icon-indigo', subtitle: 'Task automation & scheduling', pillClass: 'pill-indigo', iconBgClass: 'icon-bg-indigo' },
  'Design': { icon: '✏️', iconClass: 'cat-icon-fuchsia', subtitle: 'UI/UX & visual design', pillClass: 'pill-fuchsia', iconBgClass: 'icon-bg-fuchsia' },
  'Document Editing': { icon: '📄', iconClass: 'cat-icon-blue', subtitle: 'Office productivity & document tools', pillClass: 'pill-blue', iconBgClass: 'icon-bg-blue' },
  'Hardware & Software': { icon: '🖥️', iconClass: 'cat-icon-orange', subtitle: 'Hardware maintenance & system administration', pillClass: 'pill-orange', iconBgClass: 'icon-bg-orange' },
  'Tools': { icon: '🔧', iconClass: 'cat-icon-slate', subtitle: 'Development tools & environments', pillClass: 'pill-slate', iconBgClass: 'icon-bg-slate' },
};

const maxYears = computed(() => {
  if (!props.skills?.length) return 5;
  return Math.max(...props.skills.map(s => parseFloat(s.years_of_experience) || 0));
});

const skillCategories = computed(() => {
  const cats = new Set();
  props.skills?.forEach(s => s.category && cats.add(s.category));
  return cats.size;
});

const stats = computed(() => [
  { value: `${maxYears.value}+`, label: 'Years Exp', classes: 'bg-[#111] border-[#00ff88]/20', valueClass: 'text-[#00ff88]' },
  { value: props.projects?.length || 0, label: 'Projects', classes: 'bg-[#111] border-amber-500/20', valueClass: 'text-amber-500' },
  { value: props.skills?.length || 0, label: 'Technologies', classes: 'bg-[#111] border-emerald-500/20', valueClass: 'text-emerald-500' },
  { value: props.certifications?.length || 0, label: 'Certifications', classes: 'bg-[#111] border-sky-500/20', valueClass: 'text-sky-500' },
]);

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

const timelineItems = computed(() => {
  const items = [];

  // Add experiences
  (props.experiences || []).forEach(exp => {
    items.push({
      title: exp.job_title,
      subtitle: `${exp.company_name} · ${exp.company_location}`,
      period: exp.is_current ? `${formatDate(exp.start_date)} — Present` : `${formatDate(exp.start_date)} — ${formatDate(exp.end_date)}`,
      description: exp.description ? exp.description.substring(0, 120) + (exp.description.length > 120 ? '...' : '') : '',
      emoji: '💼',
      dotColor: 'bg-[#00ff88]',
      date: new Date(exp.start_date),
    });
  });

  // Add education
  (props.education || []).forEach(edu => {
    items.push({
      title: `${edu.degree} in ${edu.field_of_study}`,
      subtitle: `${edu.institution_name} · ${edu.location || ''}`,
      period: edu.is_current ? `${formatDate(edu.start_date)} — Present` : `${formatDate(edu.start_date)} — ${formatDate(edu.end_date)}`,
      description: edu.grade ? `Grade: ${edu.grade}` : '',
      emoji: '🎓',
      dotColor: 'bg-emerald-500',
      date: new Date(edu.start_date),
    });
  });

  // Add certifications
  (props.certifications || []).forEach(cert => {
    items.push({
      title: cert.name,
      subtitle: cert.issuing_organization,
      period: formatDate(cert.issue_date),
      description: '',
      emoji: '🏅',
      dotColor: 'bg-amber-500',
      date: new Date(cert.issue_date),
    });
  });

  // Sort by date descending
  items.sort((a, b) => b.date - a.date);
  return items;
});

const exploreLinks = computed(() => [
  { route: 'portfolio.experience', emoji: '📈', title: 'Experience', desc: `${(props.experiences || []).length} professional milestones`, iconBg: 'bg-emerald-500/10' },
  { route: 'portfolio.projects', emoji: '🏗️', title: 'Projects', desc: `${(props.projects || []).length} real-world applications built`, iconBg: 'bg-amber-500/10' },
  { route: 'portfolio.contact', emoji: '✉️', title: 'Contact', desc: 'Get in touch for collaborations', iconBg: 'bg-sky-500/10' },
]);
</script>

<style scoped>
/* About Me Hero Image */
.about-image-wrapper {
  position: relative;
  display: inline-block;
}

.about-arc {
  animation: arcSpin 30s linear infinite;
}

@keyframes arcSpin {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

.about-image-circle {
  transition: transform 0.5s cubic-bezier(.4,0,.2,1), box-shadow 0.5s ease;
}

.about-image-circle:hover {
  transform: scale(1.03);
  box-shadow: 0 0 40px -10px rgba(0,255,136,0.25);
}

/* Orbiting dots — planets around the sun */
.orbit {
  position: absolute;
  top: 50%;
  left: 50%;
  border-radius: 50%;
  pointer-events: none;
  z-index: 10;
}

.orbit-dot {
  position: absolute;
  border-radius: 50%;
  background: #00ff88;
  top: 0;
  left: 50%;
  transform: translate(-50%, -50%);
}

/* Planet 1 — large, close orbit, 20s */
.orbit-1 {
  width: 310px; height: 310px;
  margin-top: -155px; margin-left: -155px;
  animation: planetOrbit 20s linear infinite;
}
.orbit-dot-lg {
  width: 12px; height: 12px;
  box-shadow: 0 0 16px 3px rgba(0,255,136,0.7), 0 0 6px rgba(0,255,136,0.4);
  animation: dotGlow 3s ease-in-out infinite;
}

/* Planet 2 — medium, wider orbit, 28s, starts at 90° */
.orbit-2 {
  width: 330px; height: 330px;
  margin-top: -165px; margin-left: -165px;
  animation: planetOrbit 28s linear infinite;
  animation-delay: -7s;
}
.orbit-dot-md {
  width: 9px; height: 9px;
  box-shadow: 0 0 14px 2px rgba(0,255,136,0.6), 0 0 5px rgba(0,255,136,0.35);
  animation: dotGlow 3.5s ease-in-out infinite 0.8s;
}

/* Planet 3 — small, medium orbit, 35s, starts at 200° */
.orbit-3 {
  width: 295px; height: 295px;
  margin-top: -147.5px; margin-left: -147.5px;
  animation: planetOrbit 35s linear infinite reverse;
  animation-delay: -15s;
}
.orbit-dot-sm {
  width: 7px; height: 7px;
  opacity: 0.85;
  box-shadow: 0 0 10px 2px rgba(0,255,136,0.5), 0 0 4px rgba(0,255,136,0.3);
  animation: dotGlow 4s ease-in-out infinite 1.5s;
}

/* Planet 4 — tiny, tight orbit, 45s reverse */
.orbit-4 {
  width: 270px; height: 270px;
  margin-top: -135px; margin-left: -135px;
  animation: planetOrbit 45s linear infinite;
  animation-delay: -30s;
}
.orbit-dot-xs {
  width: 5px; height: 5px;
  opacity: 0.6;
  box-shadow: 0 0 8px 1px rgba(0,255,136,0.4);
  animation: dotGlow 5s ease-in-out infinite 2s;
}

@keyframes planetOrbit {
  from { transform: rotate(0deg); }
  to { transform: rotate(360deg); }
}

@keyframes dotGlow {
  0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(0.85); }
  50% { opacity: 1; transform: translate(-50%, -50%) scale(1.2); }
}

.stat-card {
  backdrop-filter: blur(4px);
}
.stat-card:hover {
  box-shadow: 0 8px 24px -6px rgba(0,255,136,0.08);
}

/* ---- 3D Category Icon Cube ---- */
.cat-icon-3d { width: 60px; height: 60px; perspective: 200px; }
.cat-icon-face { width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 16px; transform: rotateY(-8deg) rotateX(5deg); transition: transform 0.4s cubic-bezier(.4,0,.2,1), box-shadow 0.4s ease; }
.group\/cat:hover .cat-icon-face { transform: rotateY(0deg) rotateX(0deg) scale(1.08); }

.cat-icon-violet .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(139,92,246,0.3); box-shadow: 0 8px 24px -4px rgba(139,92,246,0.15), inset 0 1px 0 rgba(139,92,246,0.1); }
.cat-icon-sky .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(56,189,248,0.3); box-shadow: 0 8px 24px -4px rgba(2,132,199,0.15), inset 0 1px 0 rgba(56,189,248,0.1); }
.cat-icon-emerald .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(52,211,153,0.3); box-shadow: 0 8px 24px -4px rgba(5,150,105,0.15), inset 0 1px 0 rgba(52,211,153,0.1); }
.cat-icon-pink .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(244,114,182,0.3); box-shadow: 0 8px 24px -4px rgba(219,39,119,0.15), inset 0 1px 0 rgba(244,114,182,0.1); }
.cat-icon-amber .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(251,191,36,0.3); box-shadow: 0 8px 24px -4px rgba(217,119,6,0.15), inset 0 1px 0 rgba(251,191,36,0.1); }
.cat-icon-red .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(248,113,113,0.3); box-shadow: 0 8px 24px -4px rgba(220,38,38,0.15), inset 0 1px 0 rgba(248,113,113,0.1); }
.cat-icon-indigo .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(129,140,248,0.3); box-shadow: 0 8px 24px -4px rgba(79,70,229,0.15), inset 0 1px 0 rgba(129,140,248,0.1); }
.cat-icon-fuchsia .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(232,121,249,0.3); box-shadow: 0 8px 24px -4px rgba(192,38,211,0.15), inset 0 1px 0 rgba(232,121,249,0.1); }
.cat-icon-slate .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(148,163,184,0.3); box-shadow: 0 8px 24px -4px rgba(71,85,105,0.15), inset 0 1px 0 rgba(148,163,184,0.1); }
.cat-icon-default .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(167,139,250,0.3); box-shadow: 0 8px 24px -4px rgba(124,58,237,0.12), inset 0 1px 0 rgba(167,139,250,0.1); }
.cat-icon-blue .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(96,165,250,0.3); box-shadow: 0 8px 24px -4px rgba(37,99,235,0.15), inset 0 1px 0 rgba(96,165,250,0.1); }
.cat-icon-orange .cat-icon-face { background: linear-gradient(135deg, #1a1a1a, #111); border: 1px solid rgba(251,146,60,0.3); box-shadow: 0 8px 24px -4px rgba(234,88,12,0.15), inset 0 1px 0 rgba(251,146,60,0.1); }

/* ---- Tech Pills ---- */
.tech-pill { display: inline-flex; align-items: center; gap: 10px; padding: 6px 16px 6px 6px; border-radius: 14px; border: 1px solid; transition: all 0.3s cubic-bezier(.4,0,.2,1); backdrop-filter: blur(4px); }
.tech-pill:hover { transform: translateY(-2px); }
.tech-icon-mini { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 9px; background: linear-gradient(145deg, #1a1a1a, #111); box-shadow: 0 3px 10px -2px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.05); transform: perspective(80px) rotateY(-3deg) rotateX(2deg); transition: transform 0.3s cubic-bezier(.4,0,.2,1), box-shadow 0.3s ease; flex-shrink: 0; }
.tech-pill:hover .tech-icon-mini { transform: perspective(80px) rotateY(0deg) rotateX(0deg) scale(1.1); box-shadow: 0 5px 16px -3px rgba(0,0,0,0.4), 0 2px 4px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.05); }

/* Fallback icon backgrounds */
.icon-bg-violet { background: linear-gradient(135deg, #8b5cf6, #7c3aed); box-shadow: 0 3px 10px -2px rgba(124,58,237,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-sky { background: linear-gradient(135deg, #38bdf8, #0284c7); box-shadow: 0 3px 10px -2px rgba(2,132,199,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-emerald { background: linear-gradient(135deg, #34d399, #059669); box-shadow: 0 3px 10px -2px rgba(5,150,105,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-pink { background: linear-gradient(135deg, #f472b6, #db2777); box-shadow: 0 3px 10px -2px rgba(219,39,119,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-amber { background: linear-gradient(135deg, #fbbf24, #d97706); box-shadow: 0 3px 10px -2px rgba(217,119,6,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-red { background: linear-gradient(135deg, #f87171, #dc2626); box-shadow: 0 3px 10px -2px rgba(220,38,38,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-indigo { background: linear-gradient(135deg, #818cf8, #4f46e5); box-shadow: 0 3px 10px -2px rgba(79,70,229,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-fuchsia { background: linear-gradient(135deg, #e879f9, #c026d3); box-shadow: 0 3px 10px -2px rgba(192,38,211,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-blue { background: linear-gradient(135deg, #60a5fa, #2563eb); box-shadow: 0 3px 10px -2px rgba(37,99,235,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-orange { background: linear-gradient(135deg, #fb923c, #ea580c); box-shadow: 0 3px 10px -2px rgba(234,88,12,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-slate { background: linear-gradient(135deg, #94a3b8, #475569); box-shadow: 0 3px 10px -2px rgba(71,85,105,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }
.icon-bg-default { background: linear-gradient(135deg, #a78bfa, #7c3aed); box-shadow: 0 3px 10px -2px rgba(124,58,237,0.3), inset 0 1px 0 rgba(255,255,255,0.2); }

/* Pill color variants */
.pill-violet { background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.2); }
.pill-violet:hover { background: rgba(139,92,246,0.18); border-color: rgba(139,92,246,0.35); box-shadow: 0 4px 16px -4px rgba(139,92,246,0.2); }
.pill-sky { background: rgba(56,189,248,0.1); border-color: rgba(56,189,248,0.2); }
.pill-sky:hover { background: rgba(56,189,248,0.18); border-color: rgba(56,189,248,0.35); box-shadow: 0 4px 16px -4px rgba(56,189,248,0.2); }
.pill-emerald { background: rgba(52,211,153,0.1); border-color: rgba(52,211,153,0.2); }
.pill-emerald:hover { background: rgba(52,211,153,0.18); border-color: rgba(52,211,153,0.35); box-shadow: 0 4px 16px -4px rgba(52,211,153,0.2); }
.pill-pink { background: rgba(244,114,182,0.1); border-color: rgba(244,114,182,0.2); }
.pill-pink:hover { background: rgba(244,114,182,0.18); border-color: rgba(244,114,182,0.35); box-shadow: 0 4px 16px -4px rgba(244,114,182,0.2); }
.pill-amber { background: rgba(251,191,36,0.1); border-color: rgba(251,191,36,0.2); }
.pill-amber:hover { background: rgba(251,191,36,0.18); border-color: rgba(251,191,36,0.35); box-shadow: 0 4px 16px -4px rgba(251,191,36,0.2); }
.pill-red { background: rgba(248,113,113,0.1); border-color: rgba(248,113,113,0.2); }
.pill-red:hover { background: rgba(248,113,113,0.18); border-color: rgba(248,113,113,0.35); box-shadow: 0 4px 16px -4px rgba(248,113,113,0.2); }
.pill-indigo { background: rgba(129,140,248,0.1); border-color: rgba(129,140,248,0.2); }
.pill-indigo:hover { background: rgba(129,140,248,0.18); border-color: rgba(129,140,248,0.35); box-shadow: 0 4px 16px -4px rgba(129,140,248,0.2); }
.pill-fuchsia { background: rgba(232,121,249,0.1); border-color: rgba(232,121,249,0.2); }
.pill-fuchsia:hover { background: rgba(232,121,249,0.18); border-color: rgba(232,121,249,0.35); box-shadow: 0 4px 16px -4px rgba(232,121,249,0.2); }
.pill-slate { background: rgba(148,163,184,0.1); border-color: rgba(148,163,184,0.2); }
.pill-slate:hover { background: rgba(148,163,184,0.18); border-color: rgba(148,163,184,0.35); box-shadow: 0 4px 16px -4px rgba(148,163,184,0.2); }
.pill-blue { background: rgba(96,165,250,0.1); border-color: rgba(96,165,250,0.2); }
.pill-blue:hover { background: rgba(96,165,250,0.18); border-color: rgba(96,165,250,0.35); box-shadow: 0 4px 16px -4px rgba(96,165,250,0.2); }
.pill-orange { background: rgba(251,146,60,0.1); border-color: rgba(251,146,60,0.2); }
.pill-orange:hover { background: rgba(251,146,60,0.18); border-color: rgba(251,146,60,0.35); box-shadow: 0 4px 16px -4px rgba(251,146,60,0.2); }
.pill-default { background: rgba(139,92,246,0.1); border-color: rgba(139,92,246,0.2); }
.pill-default:hover { background: rgba(139,92,246,0.18); border-color: rgba(139,92,246,0.35); box-shadow: 0 4px 16px -4px rgba(139,92,246,0.2); }
</style>
