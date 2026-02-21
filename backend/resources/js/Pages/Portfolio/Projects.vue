<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- Semi-Hero -->
    <section class="relative pt-32 pb-20 overflow-hidden">
      <div class="absolute inset-0 bg-[#0a0a0a]"></div>
      <div class="absolute inset-0" style="background-image: linear-gradient(135deg, rgba(0,255,136,0.04) 25%, transparent 25%), linear-gradient(225deg, rgba(0,255,136,0.04) 25%, transparent 25%), linear-gradient(315deg, rgba(0,255,136,0.04) 25%, transparent 25%), linear-gradient(45deg, rgba(0,255,136,0.04) 25%, transparent 25%); background-size: 30px 30px; background-position: 0 0, 15px 0, 15px -15px, 0px 15px;"></div>
      <!-- Floating geometric accents -->
      <div class="absolute top-20 left-10 w-20 h-20 bg-[#00ff88]/10 rounded-full blur-2xl animate-pulse"></div>
      <div class="absolute bottom-10 right-20 w-32 h-32 bg-[#00ff88]/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-white/5 backdrop-blur-md rounded-3xl mb-6 border border-[#1f1f1f] shadow-2xl shadow-[#00ff88]/10 hero-icon">
          <svg class="w-12 h-12 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Projects</h1>
        <p class="text-lg text-gray-400 max-w-2xl mx-auto leading-relaxed">A showcase of my work, from personal experiments to production applications.</p>
      </div>
    </section>

    <!-- Stats Banner -->
    <section class="bg-[#0a0a0a] -mt-6 relative z-10 rounded-t-3xl">
      <div class="bg-[#111] border-b border-[#1f1f1f]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div v-for="stat in stats" :key="stat.label"
                 class="rounded-2xl p-5 text-center border transition-all duration-300 hover:-translate-y-1"
                 :class="stat.classes">
              <div class="text-3xl font-black mb-1" :class="stat.valueClass">{{ stat.value }}</div>
              <div class="text-xs font-semibold text-gray-500 uppercase tracking-wide">{{ stat.label }}</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Featured Project Spotlight -->
      <div v-if="featuredProject" class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20">
        <div class="text-center mb-10">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3 flex items-center justify-center gap-2">
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
            Featured Project
            <span class="w-8 h-0.5 bg-[#00ff88] rounded-full"></span>
          </h2>
        </div>
        <div class="bg-[#111] rounded-3xl border border-[#1f1f1f] shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-500 group">
          <div class="grid grid-cols-1 lg:grid-cols-2">
            <!-- Demo preview side -->
            <div class="h-64 lg:h-auto min-h-[280px] bg-gradient-to-br from-[#0a0a0a] via-[#111] to-[#1a1a1a] relative overflow-hidden flex items-center justify-center">
              <div class="text-center p-8">
                <div class="w-20 h-20 rounded-3xl bg-[#1a1a1a] backdrop-blur-sm flex items-center justify-center mx-auto mb-5 shadow-lg group-hover:scale-110 transition-transform duration-500 border border-[#1f1f1f]">
                  <svg class="w-10 h-10 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                </div>
                <p class="text-[#00ff88] font-bold text-lg mb-3">{{ featuredProject.title }}</p>
                <button v-if="featuredProject.live_url" @click="openPreview(featuredProject)"
                        class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-6 py-3 rounded-xl text-sm font-bold hover:bg-[#00cc6a] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 group/btn">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  View Demo
                  <svg class="w-3.5 h-3.5 group-hover/btn:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>
                <p v-else class="text-[#00ff88]/60 text-sm">Demo coming soon</p>
              </div>
              <div class="absolute top-4 left-4 bg-[#00ff88] px-3 py-1.5 rounded-full text-xs font-bold text-black shadow-md">
                ★ Featured
              </div>
            </div>
            <!-- Content side -->
            <div class="p-8 lg:p-10 flex flex-col justify-center">
              <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 text-[#00ff88] px-3 py-1 rounded-full text-xs font-bold tracking-wider uppercase mb-4 w-fit">
                {{ featuredProject.project_type }}
              </div>
              <h3 class="text-2xl lg:text-3xl font-black text-white mb-3 group-hover:text-[#00ff88] transition">{{ featuredProject.title }}</h3>
              <p class="text-gray-400 leading-relaxed mb-5">{{ featuredProject.description }}</p>
              <!-- Highlights -->
              <div v-if="featuredProject.highlights?.length" class="space-y-2 mb-5">
                <div v-for="hl in featuredProject.highlights" :key="hl"
                     class="flex items-center gap-2 text-sm text-gray-400">
                  <svg class="w-4 h-4 text-[#00ff88] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  {{ hl }}
                </div>
              </div>
              <!-- Tech stack with icons -->
              <div class="flex flex-wrap gap-2 mb-6">
                <span v-for="tech in featuredProject.technologies" :key="tech"
                      class="inline-flex items-center gap-1.5 bg-[#1a1a1a] text-gray-300 px-3 py-1.5 rounded-lg text-xs font-semibold border border-[#1f1f1f]">
                  <img v-if="hasIcon(tech)" :src="getIconUrl(tech)" :alt="tech"
                       class="w-3.5 h-3.5" @error="onIconError(tech, $event)">
                  <span v-else class="w-1.5 h-1.5 rounded-full bg-[#00ff88]"></span>
                  {{ tech }}
                </span>
              </div>
              <!-- Role & Team info -->
              <div class="flex flex-wrap items-center gap-4 text-xs text-gray-500 mb-6">
                <span v-if="featuredProject.role" class="inline-flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  {{ featuredProject.role }}
                </span>
                <span v-if="featuredProject.start_date" class="inline-flex items-center gap-1.5">
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                  {{ formatDate(featuredProject.start_date) }}{{ featuredProject.is_ongoing ? ' — Present' : featuredProject.end_date ? ` — ${formatDate(featuredProject.end_date)}` : '' }}
                </span>
              </div>
              <!-- Action buttons -->
              <div class="flex items-center gap-3">
                <a v-if="featuredProject.live_url" :href="featuredProject.live_url" target="_blank"
                   class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-6 py-2.5 rounded-xl text-sm font-bold hover:bg-[#00cc6a] transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                  Live Demo
                  <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                <a v-if="featuredProject.github_url" :href="featuredProject.github_url" target="_blank"
                   class="inline-flex items-center gap-2 border border-[#1f1f1f] text-gray-300 px-6 py-2.5 rounded-xl text-sm font-bold hover:border-[#00ff88]/30 hover:bg-[#1a1a1a] transition-all">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                  Source Code
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- All Projects -->
    <section class="py-20 bg-[#0a0a0a]">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3">Portfolio</h2>
          <p class="text-3xl font-black text-white">All Projects</p>
        </div>

        <!-- Filter bar -->
        <div v-if="projectTypes.length > 1" class="flex flex-wrap justify-center gap-2 mb-12">
          <button @click="activeFilter = null"
                  class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                  :class="activeFilter === null ? 'bg-[#00ff88] text-black shadow-lg shadow-[#00ff88]/25' : 'bg-[#1a1a1a] text-gray-400 border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:text-[#00ff88]'">
            All <span class="ml-1.5 text-xs opacity-70">({{ projects?.length || 0 }})</span>
          </button>
          <button v-for="type in projectTypes" :key="type" @click="activeFilter = type"
                  class="px-5 py-2.5 rounded-xl text-sm font-semibold transition-all duration-200"
                  :class="activeFilter === type ? 'bg-[#00ff88] text-black shadow-lg shadow-[#00ff88]/25' : 'bg-[#1a1a1a] text-gray-400 border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:text-[#00ff88]'">
            {{ type }} <span class="ml-1.5 text-xs opacity-70">({{ typeCount(type) }})</span>
          </button>
        </div>

        <!-- Project grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          <div v-for="project in filteredProjects" :key="project.id"
               class="group bg-[#111] rounded-2xl border border-[#1f1f1f] overflow-hidden hover:shadow-xl hover:shadow-[#00ff88]/5 hover:-translate-y-1 transition-all duration-300 relative">
            <!-- Accent bar -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-[#00ff88] via-[#00cc6a] to-[#00ff88] opacity-0 group-hover:opacity-100 transition-opacity duration-300 z-10"></div>

            <!-- Header area with Demo button -->
            <div class="bg-gradient-to-br from-[#0a0a0a] via-[#111] to-[#1a1a1a] relative overflow-hidden">
              <!-- Badges row -->
              <div class="flex items-center justify-between p-3">
                <div class="flex items-center gap-2">
                  <div v-if="project.is_featured" class="bg-[#00ff88] px-2.5 py-1 rounded-full text-xs font-bold text-black shadow-sm">
                    ★ Featured
                  </div>
                  <div v-if="project.is_ongoing" class="inline-flex items-center gap-1.5 bg-emerald-500 text-white px-2.5 py-1 rounded-full text-xs font-bold shadow-sm">
                    <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                    Active
                  </div>
                </div>
                <span class="bg-[#1a1a1a] backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold shadow-sm border border-[#1f1f1f]"
                      :class="typeColor(project.project_type)">
                  {{ project.project_type }}
                </span>
              </div>
              <!-- Demo button center -->
              <div class="flex items-center justify-center pb-5 pt-2">
                <button v-if="project.live_url" @click="openPreview(project)"
                        class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-5 py-2.5 rounded-xl text-sm font-bold hover:bg-[#00cc6a] transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 group/btn">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                  View Demo
                </button>
                <span v-else class="inline-flex items-center gap-2 text-gray-500 text-xs font-medium px-4 py-2">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                  Demo coming soon
                </span>
              </div>
            </div>

            <!-- Content -->
            <div class="p-6">
              <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#00ff88] transition leading-tight">{{ project.title }}</h3>
              <p class="text-gray-400 text-sm mb-4 leading-relaxed line-clamp-2">{{ project.description }}</p>

              <!-- Role -->
              <div v-if="project.role" class="flex items-center gap-1.5 text-xs text-gray-500 mb-4">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                {{ project.role }}
              </div>

              <!-- Tech stack with icons -->
              <div class="flex flex-wrap gap-1.5 mb-5">
                <span v-for="tech in (project.technologies || []).slice(0, 5)" :key="tech"
                      class="inline-flex items-center gap-1 text-xs bg-[#1a1a1a] text-gray-400 px-2.5 py-1 rounded-lg border border-[#1f1f1f] font-medium">
                  <img v-if="hasIcon(tech)" :src="getIconUrl(tech)" :alt="tech"
                       class="w-3 h-3" @error="onIconError(tech, $event)">
                  {{ tech }}
                </span>
                <span v-if="(project.technologies || []).length > 5"
                      class="text-xs text-gray-500 px-2 py-1 font-medium">
                  +{{ project.technologies.length - 5 }} more
                </span>
              </div>

              <!-- Highlights mini-list -->
              <div v-if="project.highlights?.length" class="mb-5 space-y-1">
                <div v-for="hl in project.highlights.slice(0, 2)" :key="hl"
                     class="flex items-start gap-1.5 text-xs text-gray-400">
                  <svg class="w-3.5 h-3.5 text-[#00ff88] shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  <span>{{ hl }}</span>
                </div>
              </div>

              <!-- Action links -->
              <div class="flex items-center justify-between pt-4 border-t border-[#1f1f1f]">
                <a v-if="project.github_url" :href="project.github_url" target="_blank"
                   class="text-gray-500 hover:text-white flex items-center gap-1.5 text-sm transition group/link">
                  <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                  <span class="group-hover/link:underline">Code</span>
                </a>
                <span v-else></span>
                <a v-if="project.live_url" :href="project.live_url" target="_blank"
                   class="text-[#00ff88] hover:text-[#00cc6a] flex items-center gap-1.5 text-sm font-semibold transition group/link">
                  Live Demo
                  <svg class="w-3.5 h-3.5 group-hover/link:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
              </div>
            </div>
          </div>
        </div>

        <!-- Empty State -->
        <div v-if="!projects?.length" class="text-center py-20">
          <div class="w-20 h-20 rounded-3xl bg-[#1a1a1a] flex items-center justify-center mx-auto mb-5 border border-[#1f1f1f]">
            <svg class="w-10 h-10 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
          </div>
          <p class="text-gray-400 text-lg font-medium">No projects yet.</p>
          <p class="text-gray-500 text-sm mt-1">Check back soon — exciting things are in the works.</p>
        </div>
      </div>
    </section>

    <!-- Tech Stack Summary -->
    <section v-if="allTechnologies.length" class="py-20 bg-[#0a0a0a]">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
          <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-3">Technology Stack</h2>
          <p class="text-3xl font-black text-white">Built With</p>
        </div>
        <div class="flex flex-wrap justify-center gap-3">
          <span v-for="tech in allTechnologies" :key="tech.name"
                class="inline-flex items-center gap-2 bg-[#1a1a1a] text-gray-300 px-4 py-2.5 rounded-xl text-sm font-semibold border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:shadow-md hover:shadow-[#00ff88]/5 transition-all duration-300 hover:-translate-y-0.5">
            <img v-if="hasIcon(tech.name)" :src="getIconUrl(tech.name)" :alt="tech.name"
                 class="w-4 h-4" @error="onIconError(tech.name, $event)">
            <span v-else class="w-2 h-2 rounded-full bg-[#00ff88]"></span>
            {{ tech.name }}
            <span class="text-xs text-gray-500 bg-[#111] px-1.5 py-0.5 rounded-md ml-0.5">{{ tech.count }}</span>
          </span>
        </div>
      </div>
    </section>

    <!-- CTA Banner -->
    <section class="py-16 bg-[#111] relative overflow-hidden">
      <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg%20width%3D%2260%22%20height%3D%2260%22%20viewBox%3D%220%200%2060%2060%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%3Cg%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cg%20fill%3D%22%2300ff88%22%20fill-opacity%3D%220.04%22%3E%3Cpath%20d%3D%22M36%2034v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6%2034v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6%204V0H4v4H0v2h4v4h2V6h4V4H6z%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E')] opacity-40"></div>
      <div class="absolute top-0 left-0 right-0 h-px" style="background: linear-gradient(90deg, transparent, #00ff88, transparent);"></div>
      <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-black text-white mb-4">Have a project in mind?</h2>
        <p class="text-gray-400 mb-8 max-w-xl mx-auto">I'm always excited to take on new challenges and build something amazing together.</p>
        <div class="flex flex-wrap justify-center gap-4">
          <Link :href="route('portfolio.contact')"
                class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-8 py-3.5 rounded-2xl font-bold hover:bg-[#00cc6a] transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
            Let's Talk
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
          <Link :href="route('portfolio.about')"
                class="inline-flex items-center gap-2 border-2 border-[#1f1f1f] text-white px-8 py-3.5 rounded-2xl font-bold hover:bg-white/5 hover:border-[#00ff88]/30 transition-all">
            View My Skills
          </Link>
        </div>
      </div>
    </section>
    <!-- Demo Preview Modal -->
    <Teleport to="body">
      <Transition name="preview">
        <div v-if="previewProject" class="fixed inset-0 z-[100] flex flex-col bg-[#0a0a0a]/95 backdrop-blur-sm" @click.self="closePreview">
          <!-- Modal header -->
          <div class="flex items-center justify-between px-4 sm:px-6 py-3 bg-[#0a0a0a] border-b border-[#1f1f1f] shrink-0">
            <div class="flex items-center gap-3 min-w-0">
              <div class="w-8 h-8 rounded-lg bg-[#00ff88] flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
              </div>
              <div class="min-w-0">
                <h3 class="text-white font-bold text-sm truncate">{{ previewProject.title }}</h3>
                <p class="text-gray-500 text-xs truncate">{{ previewProject.live_url }}</p>
              </div>
            </div>
            <div class="flex items-center gap-2 shrink-0">
              <a :href="previewProject.live_url" target="_blank" rel="noopener noreferrer"
                 class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-white px-3 py-1.5 rounded-lg hover:bg-white/10 transition font-medium">
                Open in new tab
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
              </a>
              <button @click="closePreview"
                      class="w-8 h-8 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
              </button>
            </div>
          </div>
          <!-- Iframe -->
          <div class="flex-1 relative">
            <div v-if="previewLoading" class="absolute inset-0 flex items-center justify-center">
              <div class="text-center">
                <div class="w-10 h-10 border-4 border-[#00ff88] border-t-transparent rounded-full animate-spin mx-auto mb-3"></div>
                <p class="text-gray-400 text-sm">Loading preview...</p>
              </div>
            </div>
            <iframe :src="previewProject.live_url" 
                    class="w-full h-full border-0 bg-white"
                    @load="previewLoading = false"
                    sandbox="allow-scripts allow-same-origin allow-forms allow-popups"
                    referrerpolicy="no-referrer"></iframe>
          </div>
        </div>
      </Transition>
    </Teleport>
  </PortfolioLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import PortfolioLayout from '@/Layouts/PortfolioLayout.vue';
import { useTechIcons } from '@/composables/useTechIcons.js';

const { getIconUrl, hasIcon, onIconError } = useTechIcons();

const props = defineProps({
  meta: Object,
  projects: Array,
  skills: Array,
});

const activeFilter = ref(null);
const previewProject = ref(null);
const previewLoading = ref(true);

const openPreview = (project) => {
  previewProject.value = project;
  previewLoading.value = true;
};

const closePreview = () => {
  previewProject.value = null;
};

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};

const featuredProject = computed(() => (props.projects || []).find(p => p.is_featured));

const projectTypes = computed(() => {
  const types = new Set(props.projects?.map(p => p.project_type).filter(Boolean) || []);
  return [...types];
});

const typeCount = (type) => (props.projects || []).filter(p => p.project_type === type).length;

const typeColor = (type) => {
  const colors = {
    'Professional': 'text-[#00ff88]',
    'Personal': 'text-sky-400',
    'Open Source': 'text-emerald-400',
    'Academic': 'text-amber-400',
  };
  return colors[type] || 'text-gray-400';
};

const filteredProjects = computed(() => {
  if (!activeFilter.value) return props.projects || [];
  return (props.projects || []).filter(p => p.project_type === activeFilter.value);
});

const allTechnologies = computed(() => {
  const techMap = {};
  (props.projects || []).forEach(p => {
    (p.technologies || []).forEach(t => {
      techMap[t] = (techMap[t] || 0) + 1;
    });
  });
  return Object.entries(techMap)
    .map(([name, count]) => ({ name, count }))
    .sort((a, b) => b.count - a.count);
});

const stats = computed(() => {
  const all = props.projects || [];
  const ongoing = all.filter(p => p.is_ongoing).length;
  const featured = all.filter(p => p.is_featured).length;
  const techCount = new Set(all.flatMap(p => p.technologies || [])).size;
  return [
    { value: all.length, label: 'Total Projects', classes: 'bg-[#1a1a1a] border-[#1f1f1f]', valueClass: 'text-[#00ff88]' },
    { value: featured, label: 'Featured', classes: 'bg-[#1a1a1a] border-[#1f1f1f]', valueClass: 'text-[#00ff88]' },
    { value: ongoing, label: 'Active Now', classes: 'bg-[#1a1a1a] border-[#1f1f1f]', valueClass: 'text-emerald-400' },
    { value: techCount, label: 'Technologies', classes: 'bg-[#1a1a1a] border-[#1f1f1f]', valueClass: 'text-sky-400' },
  ];
});
</script>

<style scoped>
.hero-icon {
  transform: perspective(150px) rotateY(-5deg) rotateX(3deg);
  transition: transform 0.5s cubic-bezier(.4,0,.2,1);
}
.hero-icon:hover {
  transform: perspective(150px) rotateY(0deg) rotateX(0deg) scale(1.05);
}
.line-clamp-2 {
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.preview-enter-active,
.preview-leave-active {
  transition: opacity 0.25s ease;
}
.preview-enter-from,
.preview-leave-to {
  opacity: 0;
}
</style>
