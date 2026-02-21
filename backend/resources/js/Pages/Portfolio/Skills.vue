<template>
  <Head :title="meta.title">
    <meta name="description" :content="meta.description">
    <meta property="og:title" :content="meta.title + ' — jaykod.io'">
    <meta property="og:description" :content="meta.description">
  </Head>
  <PortfolioLayout>
    <!-- Semi-Hero -->
    <section class="relative pt-32 pb-16 overflow-hidden" style="background-color: #0a0a0a;">
      <div class="absolute inset-0" style="background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(0,255,136,0.03) 10px, rgba(0,255,136,0.03) 11px), repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(0,255,136,0.03) 10px, rgba(0,255,136,0.03) 11px), radial-gradient(rgba(0,255,136,0.06) 1px, transparent 1px); background-size: auto, auto, 22px 22px; background-position: 0 0, 0 0, 11px 11px;"></div>
      <div class="relative max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 backdrop-blur-sm rounded-2xl mb-6 border" style="background-color: rgba(0,255,136,0.1); border-color: rgba(0,255,136,0.2);">
          <svg class="w-8 h-8 text-[#00ff88]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" /></svg>
        </div>
        <h1 class="text-4xl md:text-5xl font-black text-white mb-4">Skills & Technologies</h1>
        <p class="text-lg text-[#00ff88] max-w-2xl mx-auto">A comprehensive look at the technologies, tools, and frameworks I work with.</p>
      </div>
    </section>

    <!-- Skills Content -->
    <section class="py-20 -mt-4 relative z-10 rounded-t-3xl" style="background-color: #0a0a0a;">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Quick overview pills -->
        <div class="flex flex-wrap justify-center gap-3 mb-16">
          <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border font-semibold text-sm" style="background-color: rgba(0,255,136,0.1); color: #00ff88; border-color: rgba(0,255,136,0.2);">
            <span class="text-lg">🚀</span> {{ skills?.length || 0 }} Technologies
          </div>
          <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full border font-semibold text-sm" style="background-color: rgba(0,255,136,0.05); color: #9ca3af; border-color: #1f1f1f;">
            <span class="text-lg">📂</span> {{ Object.keys(groupedSkills).length }} Categories
          </div>
        </div>

        <!-- Category Blocks -->
        <div class="space-y-16">
          <div v-for="(categorySkills, category) in groupedSkills" :key="category"
               class="group/cat">

            <!-- Category Header with 3D Icon -->
            <div class="flex items-center gap-5 mb-8">
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

            <!-- Tech Pills with 3D Logos -->
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
  </PortfolioLayout>
</template>

<script setup>
import { computed } from 'vue';
import { Head } from '@inertiajs/vue3';
import PortfolioLayout from '@/Layouts/PortfolioLayout.vue';
import { useTechIcons } from '@/composables/useTechIcons';

const { getIconUrl, hasIcon, onIconError } = useTechIcons();

const props = defineProps({
  meta: Object,
  skills: Array,
});

const groupedSkills = computed(() => {
  const groups = {};
  const order = ['Backend', 'Frontend', 'Database', 'AI & ML', 'DevOps & Cloud', 'Cybersecurity', 'Automation', 'Design', 'Document Editing', 'Hardware & Software', 'Tools'];
  props.skills?.forEach(s => {
    if (!groups[s.category]) groups[s.category] = [];
    groups[s.category].push(s);
  });
  // Sort by defined order
  const sorted = {};
  order.forEach(cat => { if (groups[cat]) sorted[cat] = groups[cat]; });
  // Add any remaining categories not in order
  Object.keys(groups).forEach(cat => { if (!sorted[cat]) sorted[cat] = groups[cat]; });
  return sorted;
});

const categoryMeta = {
  'Backend': {
    icon: '⚙️', iconClass: 'cat-icon-violet',
    subtitle: 'Server-side languages & frameworks',
    pillClass: 'pill-violet', iconBgClass: 'icon-bg-violet',
  },
  'Frontend': {
    icon: '🎨', iconClass: 'cat-icon-sky',
    subtitle: 'UI frameworks, styling & markup',
    pillClass: 'pill-sky', iconBgClass: 'icon-bg-sky',
  },
  'Database': {
    icon: '🗄️', iconClass: 'cat-icon-emerald',
    subtitle: 'Data storage & management',
    pillClass: 'pill-emerald', iconBgClass: 'icon-bg-emerald',
  },
  'AI & ML': {
    icon: '🧠', iconClass: 'cat-icon-pink',
    subtitle: 'Artificial intelligence & intelligent systems',
    pillClass: 'pill-pink', iconBgClass: 'icon-bg-pink',
  },
  'DevOps & Cloud': {
    icon: '☁️', iconClass: 'cat-icon-amber',
    subtitle: 'Deployment, infrastructure & version control',
    pillClass: 'pill-amber', iconBgClass: 'icon-bg-amber',
  },
  'Cybersecurity': {
    icon: '🛡️', iconClass: 'cat-icon-red',
    subtitle: 'Security practices & protection',
    pillClass: 'pill-red', iconBgClass: 'icon-bg-red',
  },
  'Automation': {
    icon: '🤖', iconClass: 'cat-icon-indigo',
    subtitle: 'Task automation & scheduling',
    pillClass: 'pill-indigo', iconBgClass: 'icon-bg-indigo',
  },
  'Design': {
    icon: '✏️', iconClass: 'cat-icon-fuchsia',
    subtitle: 'UI/UX & visual design',
    pillClass: 'pill-fuchsia', iconBgClass: 'icon-bg-fuchsia',
  },
  'Document Editing': {
    icon: '📄', iconClass: 'cat-icon-blue',
    subtitle: 'Office productivity & document tools',
    pillClass: 'pill-blue', iconBgClass: 'icon-bg-blue',
  },
  'Hardware & Software': {
    icon: '🖥️', iconClass: 'cat-icon-orange',
    subtitle: 'Hardware maintenance & system administration',
    pillClass: 'pill-orange', iconBgClass: 'icon-bg-orange',
  },
  'Tools': {
    icon: '🔧', iconClass: 'cat-icon-slate',
    subtitle: 'Development tools & environments',
    pillClass: 'pill-slate', iconBgClass: 'icon-bg-slate',
  },
};
</script>

<style scoped>
/* ---- 3D Category Icon Cube ---- */
.cat-icon-3d {
  width: 60px;
  height: 60px;
  perspective: 200px;
}
.cat-icon-face {
  width: 60px;
  height: 60px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 16px;
  transform: rotateY(-8deg) rotateX(5deg);
  transition: transform 0.4s cubic-bezier(.4,0,.2,1), box-shadow 0.4s ease;
}
.group\/cat:hover .cat-icon-face {
  transform: rotateY(0deg) rotateX(0deg) scale(1.08);
}

/* Icon color variants – dark theme: dark bg with subtle colored border & glow */
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
.tech-pill {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 6px 16px 6px 6px;
  border-radius: 14px;
  border: 1px solid;
  transition: all 0.3s cubic-bezier(.4,0,.2,1);
  backdrop-filter: blur(4px);
}
.tech-pill:hover {
  transform: translateY(-2px);
}
.tech-icon-mini {
  width: 32px;
  height: 32px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 9px;
  background: linear-gradient(145deg, #1a1a1a, #111);
  box-shadow: 0 3px 10px -2px rgba(0,0,0,0.3), 0 1px 2px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.05);
  transform: perspective(80px) rotateY(-3deg) rotateX(2deg);
  transition: transform 0.3s cubic-bezier(.4,0,.2,1), box-shadow 0.3s ease;
  flex-shrink: 0;
}
.tech-pill:hover .tech-icon-mini {
  transform: perspective(80px) rotateY(0deg) rotateX(0deg) scale(1.1);
  box-shadow: 0 5px 16px -3px rgba(0,0,0,0.4), 0 2px 4px rgba(0,0,0,0.2), inset 0 1px 0 rgba(255,255,255,0.05);
}

/* Fallback initial backgrounds */
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

/* Pill color variants – dark theme */
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
