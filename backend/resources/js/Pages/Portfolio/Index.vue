<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-24 overflow-hidden" style="background-color: #0a0a0a;">
      <div class="absolute inset-0" style="background-image: radial-gradient(rgba(0,255,136,0.08) 1px, transparent 1px), radial-gradient(rgba(0,255,136,0.05) 1px, transparent 1px), linear-gradient(to right, rgba(0,255,136,0.04) 1px, transparent 1px), linear-gradient(to bottom, rgba(0,255,136,0.04) 1px, transparent 1px); background-size: 40px 40px, 20px 20px, 40px 40px, 40px 40px; background-position: 0 0, 10px 10px, 0 0, 0 0;"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 backdrop-blur-sm text-[#00ff88] text-sm font-medium px-4 py-2 rounded-full mb-8 border border-[#00ff88]/20">
          <span class="w-2 h-2 bg-[#00ff88] rounded-full animate-pulse"></span>
          Open to Opportunities
        </div>
        <h1 class="text-5xl md:text-7xl font-black text-white mb-6 leading-tight">
          {{ heroTitle }}
        </h1>
        <p class="text-xl text-gray-400 max-w-2xl mx-auto mb-12 leading-relaxed">
          {{ bio?.content }}
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <Link :href="route('resume.create')"
                class="inline-flex items-center justify-center gap-2 bg-[#00ff88] text-black px-8 py-4 rounded-2xl font-bold text-lg hover:bg-[#00ff88]/90 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
            Get My Resume
          </Link>
          <Link :href="route('portfolio.projects')" class="inline-flex items-center justify-center gap-2 border-2 border-white/20 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all backdrop-blur-sm">
            View My Work
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
          </Link>
        </div>
      </div>
    </section>

    <!-- Quick Stats -->
    <section class="py-12 border-b" style="background-color: #111; border-color: #1f1f1f;">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
          <div v-for="stat in stats" :key="stat.label">
            <div class="text-4xl font-black text-[#00ff88]">{{ stat.value }}</div>
            <div class="text-sm text-gray-500 mt-1">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- About Me -->
    <section class="relative py-20 overflow-hidden" style="background-color: #0a0a0a;">
      <!-- Subtle pattern -->
      <div class="absolute inset-0 opacity-40" style="background-image: radial-gradient(rgba(0,255,136,0.03) 1px, transparent 1px); background-size: 24px 24px;"></div>
      <!-- Accent glow -->
      <div class="absolute -left-32 top-1/2 -translate-y-1/2 w-96 h-96 bg-[#00ff88]/5 rounded-full blur-[120px] pointer-events-none"></div>

      <div class="relative max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-center">
          <!-- Left: Profile Image -->
          <div class="flex justify-center lg:justify-start">
            <div class="about-image-wrapper relative">
              <!-- Decorative arc -->
              <svg class="about-arc absolute -inset-5 w-[calc(100%+40px)] h-[calc(100%+40px)]" viewBox="0 0 340 340" fill="none">
                <circle cx="170" cy="170" r="155" stroke="url(#arcGrad)" stroke-width="2.5" stroke-dasharray="6 8" stroke-linecap="round" opacity="0.6"/>
                <defs>
                  <linearGradient id="arcGrad" x1="0" y1="0" x2="340" y2="340">
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
                <!-- Profile image if available -->
                <img v-if="profileImage"
                     :src="profileImage"
                     alt="Profile"
                     class="w-full h-full object-cover" />
                <!-- Monogram fallback -->
                <div v-else class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#111] via-[#0a0a0a] to-[#111]">
                  <div class="text-center">
                    <span class="text-6xl sm:text-7xl font-black bg-gradient-to-br from-[#00ff88] to-[#00cc6a] bg-clip-text text-transparent leading-none">{{ siteIconLetter }}</span>
                    <div class="mt-2 text-xs font-bold tracking-[0.3em] text-gray-600 uppercase">Developer</div>
                  </div>
                </div>
                <!-- Subtle overlay ring -->
                <div class="absolute inset-0 rounded-full ring-1 ring-inset ring-white/5"></div>
              </div>
            </div>
          </div>

          <!-- Right: About Content -->
          <div class="text-center lg:text-left">
            <!-- Greeting badge -->
            <div class="inline-flex items-center gap-2 bg-[#00ff88]/10 text-[#00ff88] px-4 py-1.5 rounded-full text-xs font-bold tracking-widest uppercase mb-6 border border-[#00ff88]/20">
              <span class="text-sm">👋</span>
              Hi There!
            </div>

            <!-- Name -->
            <h2 class="text-4xl sm:text-5xl font-black text-white mb-3 leading-tight">
              I'm <span class="text-[#00ff88]">{{ displayName }}</span>
            </h2>

            <!-- Role tagline -->
            <div class="flex flex-wrap justify-center lg:justify-start gap-2 mb-6">
              <span v-for="(role, i) in roles" :key="i"
                    class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-sm font-bold border"
                    :class="i === 0
                      ? 'bg-[#00ff88]/15 text-[#00ff88] border-[#00ff88]/30'
                      : 'bg-[#111] text-gray-300 border-[#1f1f1f]'">
                {{ role }}
              </span>
            </div>

            <!-- Tagline -->
            <p v-if="objective" class="text-lg font-semibold text-white/90 mb-4 leading-relaxed">
              {{ objective.content?.split('.').slice(0, 1).join('.') }}.
            </p>

            <!-- Bio (truncated) -->
            <p class="text-gray-400 leading-relaxed mb-8 max-w-lg mx-auto lg:mx-0">
              {{ truncatedBio }}
            </p>

            <!-- Action buttons -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center lg:justify-start">
              <Link :href="route('portfolio.about')"
                    class="inline-flex items-center justify-center gap-2 bg-[#00ff88] text-black px-7 py-3.5 rounded-2xl font-bold hover:bg-[#00cc6a] transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                More About Me
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
              </Link>
              <Link :href="route('portfolio.contact')"
                    class="inline-flex items-center justify-center gap-2 border-2 border-[#1f1f1f] text-white px-7 py-3.5 rounded-2xl font-bold hover:bg-white/5 hover:border-[#00ff88]/30 transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                Let's Talk
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Skills Preview -->
    <section class="py-20 border-t" style="background-color: #0a0a0a; border-color: #1f1f1f;">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <div>
            <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-2">Top Skills</h2>
            <p class="text-3xl font-bold text-white">What I Work With</p>
          </div>
          <Link :href="route('portfolio.about')" class="hidden sm:inline-flex items-center gap-2 text-[#00ff88] hover:text-[#00ff88]/80 font-semibold text-sm transition">
            View All Skills
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
        </div>
        <div class="flex flex-wrap gap-3">
          <div v-for="skill in skills" :key="skill.id"
               class="inline-flex items-center gap-2.5 bg-[#111] border border-[#1f1f1f] hover:border-[#00ff88]/30 hover:shadow-lg hover:shadow-[#00ff88]/5 pl-1.5 pr-4 py-1.5 rounded-xl transition-all duration-300 hover:-translate-y-1 group cursor-default">
            <div class="w-8 h-8 rounded-lg bg-[#1a1a1a] flex items-center justify-center shrink-0" style="transform: perspective(80px) rotateY(-2deg) rotateX(1deg);">
              <img v-if="hasIcon(skill.name)" :src="getIconUrl(skill.name)" :alt="skill.name" class="w-4 h-4 object-contain" @error="(e) => onIconError(skill.name, e)" loading="lazy" />
              <span v-if="!hasIcon(skill.name)" class="text-[10px] font-black text-[#00ff88]">{{ skill.name[0] }}</span>
            </div>
            <span class="font-semibold text-sm text-gray-400 group-hover:text-[#00ff88] transition">{{ skill.name }}</span>
          </div>
        </div>
        <div class="mt-8 text-center sm:hidden">
          <Link :href="route('portfolio.about')" class="inline-flex items-center gap-2 text-[#00ff88] font-semibold text-sm">
            View All Skills →
          </Link>
        </div>
      </div>
    </section>

    <!-- Experience Preview -->
    <section class="py-20" style="background-color: #111;">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <div>
            <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-2">Career</h2>
            <p class="text-3xl font-bold text-white">Recent Experience</p>
          </div>
          <Link :href="route('portfolio.experience')" class="hidden sm:inline-flex items-center gap-2 text-[#00ff88] hover:text-[#00ff88]/80 font-semibold text-sm transition">
            Full Timeline
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
        </div>
        <div class="space-y-4">
          <div v-for="exp in experiences" :key="exp.id"
               class="bg-[#1a1a1a] rounded-2xl p-6 border border-[#1f1f1f] hover:border-[#00ff88]/20 transition-all duration-300">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mb-2">
              <h3 class="text-lg font-bold text-white">{{ exp.job_title }}</h3>
              <span class="text-sm font-medium text-[#00ff88] bg-[#00ff88]/10 px-3 py-1 rounded-full whitespace-nowrap">
                {{ formatDate(exp.start_date) }} — {{ exp.is_current ? 'Present' : formatDate(exp.end_date) }}
              </span>
            </div>
            <div class="text-gray-500 font-medium">{{ exp.company_name }} · {{ exp.company_location }}</div>
          </div>
        </div>
        <div class="mt-8 text-center sm:hidden">
          <Link :href="route('portfolio.experience')" class="inline-flex items-center gap-2 text-[#00ff88] font-semibold text-sm">
            Full Timeline →
          </Link>
        </div>
      </div>
    </section>

    <!-- Projects Preview -->
    <section class="py-20" style="background-color: #0a0a0a;">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-10">
          <div>
            <h2 class="text-sm font-bold tracking-widest text-[#00ff88] uppercase mb-2">Portfolio</h2>
            <p class="text-3xl font-bold text-white">Featured Projects</p>
          </div>
          <Link :href="route('portfolio.projects')" class="hidden sm:inline-flex items-center gap-2 text-[#00ff88] hover:text-[#00ff88]/80 font-semibold text-sm transition">
            View All Projects
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <div v-for="project in projects" :key="project.id"
               class="group bg-[#111] rounded-2xl border border-[#1f1f1f] overflow-hidden hover:border-[#00ff88]/20 hover:-translate-y-1 transition-all duration-300">
            <div class="h-44 bg-[#1a1a1a] relative overflow-hidden">
              <img v-if="project.image_url" :src="project.image_url" :alt="project.title" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
              <div v-else class="w-full h-full flex items-center justify-center">
                <svg class="w-14 h-14 text-[#00ff88]/20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" /></svg>
              </div>
              <div v-if="project.is_featured" class="absolute top-3 left-3 bg-[#00ff88] px-2 py-1 rounded-full text-xs font-bold text-black">★ Featured</div>
            </div>
            <div class="p-5">
              <h3 class="text-lg font-bold text-white mb-2 group-hover:text-[#00ff88] transition">{{ project.title }}</h3>
              <p class="text-gray-500 text-sm line-clamp-2 leading-relaxed">{{ project.description }}</p>
            </div>
          </div>
        </div>
        <div class="mt-8 text-center sm:hidden">
          <Link :href="route('portfolio.projects')" class="inline-flex items-center gap-2 text-[#00ff88] font-semibold text-sm">
            View All Projects →
          </Link>
        </div>
      </div>
    </section>

    <!-- Contact CTA -->
    <section class="py-24 relative overflow-hidden" style="background-color: #111;">
      <div class="absolute inset-0" style="background-image: radial-gradient(rgba(0,255,136,0.05) 1px, transparent 1px); background-size: 30px 30px;"></div>
      <div class="absolute inset-0 pointer-events-none" style="background: radial-gradient(circle at 50% 50%, rgba(0,255,136,0.06) 0%, transparent 60%);"></div>
      <div class="relative max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-4xl font-black text-white mb-6">Let's Work Together</h2>
        <p class="text-xl text-gray-400 mb-10 max-w-2xl mx-auto">Interested in collaborating or have a project in mind?</p>
        <div class="flex flex-wrap justify-center gap-4">
          <Link :href="route('portfolio.contact')"
                class="inline-flex items-center gap-2 bg-[#00ff88] text-black px-10 py-4 rounded-2xl font-bold text-lg hover:bg-[#00ff88]/90 transition-all shadow-xl hover:shadow-2xl hover:-translate-y-1">
            Get In Touch
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </Link>
          <Link :href="route('resume.create')"
                class="inline-flex items-center gap-2 border-2 border-white/20 text-white px-10 py-4 rounded-2xl font-bold text-lg hover:bg-white/10 transition-all backdrop-blur-sm">
            Generate Resume
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
  contact: Array,
});

const siteSettings = computed(() => usePage().props.siteSettings || {});
const siteIconLetter = computed(() => siteSettings.value.site_icon_letter || 'J');
const profileImage = computed(() => siteSettings.value.site_profile_image || '');

const bio = computed(() => props.profile?.find(p => p.section_name === 'bio'));
const objective = computed(() => props.profile?.find(p => p.section_name === 'objective'));
const heroTitle = computed(() => bio.value?.content?.split('.')[0] || 'Full Stack Developer');

const displayName = computed(() => {
  const name = siteSettings.value.site_name || 'Jay';
  // Extract first name-like part (before dots, spaces, etc.)
  return name.replace(/\.\w+$/, '').replace(/\.\s*$/, '');
});

const roles = computed(() => {
  const obj = objective.value?.content || '';
  // Try to extract role-like phrases from the objective
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

const stats = computed(() => [
  { value: `${Math.max(...(props.skills?.map(s => parseFloat(s.years_of_experience)) || [5]))}+`, label: 'Years Experience' },
  { value: props.projects?.length || 0, label: 'Projects' },
  { value: props.skills?.length || 0, label: 'Technologies' },
  { value: '100%', label: 'Dedication' },
]);

const formatDate = (dateStr) => {
  if (!dateStr) return '';
  return new Date(dateStr).toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};
</script>

<style scoped>
/* About Me Section */
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
</style>
