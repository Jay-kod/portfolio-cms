<template>
  <div class="min-h-screen bg-gradient-to-b from-slate-50 to-slate-100">
    <!-- Header -->
    <header class="border-b border-slate-200 bg-white/90 backdrop-blur-sm sticky top-0 z-20">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
        <div>
          <h1 class="text-xl font-black text-slate-900">{{ resume.job_title }}</h1>
          <p v-if="resume.company_name" class="text-sm text-slate-500">{{ resume.company_name }}</p>
        </div>
        <div class="flex items-center gap-3">
          <span class="text-xs text-slate-400">
            {{ resume.view_count }} views · {{ resume.download_count }} downloads
          </span>
          <a :href="downloadUrl" target="_blank"
             class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-xl font-semibold hover:from-violet-700 hover:to-purple-700 transition-all shadow-md hover:shadow-lg text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            Download PDF
          </a>
        </div>
      </div>
    </header>

    <!-- Resume Content -->
    <main class="max-w-4xl mx-auto px-4 sm:px-6 py-10">
      <!-- Contact & Objective -->
      <section class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <div class="text-center mb-6">
          <h2 class="text-3xl font-black text-slate-900 tracking-tight">{{ profileData.name }}</h2>
          <div class="flex flex-wrap justify-center gap-x-4 gap-y-1 mt-2 text-sm text-slate-500">
            <span v-for="c in contactItems" :key="c.id" class="flex items-center gap-1">
              <svg class="w-3.5 h-3.5 text-violet-500" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="3" /></svg>
              {{ c.display_name || c.value }}
            </span>
          </div>
        </div>
        <div v-if="resume.custom_objective" class="border-t border-slate-100 pt-6">
          <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-2">Objective</h3>
          <p class="text-slate-700 leading-relaxed">{{ resume.custom_objective }}</p>
        </div>
      </section>

      <!-- Skills -->
      <section v-if="selectedSkills.length" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-5">Technical Skills</h3>
        <div v-for="(skills, category) in groupedSkills" :key="category" class="mb-4 last:mb-0">
          <span class="font-bold text-slate-700 text-sm">{{ category }}:</span>
          <span class="text-sm text-slate-600 ml-2">{{ skills.map(s => s.name).join(', ') }}</span>
        </div>
      </section>

      <!-- Experience -->
      <section v-if="selectedExperiences.length" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-5">Professional Experience</h3>
        <div v-for="exp in selectedExperiences" :key="exp.id" class="mb-6 last:mb-0 pb-6 last:pb-0 border-b last:border-0 border-slate-100">
          <div class="flex items-start justify-between">
            <div>
              <h4 class="font-bold text-slate-800 text-lg">{{ exp.job_title }}</h4>
              <p class="text-sm text-violet-600 font-medium">{{ exp.company_name }}<span v-if="exp.location" class="text-slate-400"> · {{ exp.location }}</span></p>
            </div>
            <span class="text-xs text-slate-400 whitespace-nowrap mt-1">{{ formatDate(exp.start_date) }} — {{ exp.is_current ? 'Present' : formatDate(exp.end_date) }}</span>
          </div>
          <p v-if="exp.description" class="text-sm text-slate-600 mt-2">{{ exp.description }}</p>
          <ul v-if="exp.achievements?.length" class="mt-3 space-y-1.5">
            <li v-for="(a, i) in exp.achievements" :key="i" class="text-sm text-slate-600 flex gap-2">
              <span class="text-violet-500 font-bold mt-0.5">›</span>
              <span>{{ a }}</span>
            </li>
          </ul>
          <div v-if="exp.technologies?.length" class="flex flex-wrap gap-1.5 mt-3">
            <span v-for="t in exp.technologies" :key="t" class="text-xs bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full">{{ t }}</span>
          </div>
        </div>
      </section>

      <!-- Projects -->
      <section v-if="selectedProjects.length" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-5">Key Projects</h3>
        <div v-for="proj in selectedProjects" :key="proj.id" class="mb-5 last:mb-0 pb-5 last:pb-0 border-b last:border-0 border-slate-100">
          <h4 class="font-bold text-slate-800">{{ proj.title }}</h4>
          <p class="text-sm text-slate-600 mt-1">{{ proj.description }}</p>
          <div v-if="proj.technologies?.length" class="flex flex-wrap gap-1.5 mt-2">
            <span v-for="t in proj.technologies" :key="t" class="text-xs bg-violet-50 text-violet-600 px-2 py-0.5 rounded-full">{{ t }}</span>
          </div>
        </div>
      </section>

      <!-- Education -->
      <section v-if="education.length" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-5">Education</h3>
        <div v-for="ed in education" :key="ed.id" class="mb-4 last:mb-0">
          <div class="flex items-start justify-between">
            <div>
              <h4 class="font-bold text-slate-800">{{ ed.degree }} in {{ ed.field_of_study }}</h4>
              <p class="text-sm text-violet-600 font-medium">{{ ed.institution }}</p>
            </div>
            <span class="text-xs text-slate-400 whitespace-nowrap mt-1">{{ formatDate(ed.start_date) }} — {{ ed.end_date ? formatDate(ed.end_date) : 'Present' }}</span>
          </div>
          <p v-if="ed.grade" class="text-xs text-slate-500 mt-1">Grade: {{ ed.grade }}</p>
        </div>
      </section>

      <!-- Certifications -->
      <section v-if="certifications.length" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8 mb-6">
        <h3 class="text-xs font-bold uppercase text-slate-400 tracking-wider mb-5">Certifications</h3>
        <div class="grid sm:grid-cols-2 gap-4">
          <div v-for="cert in certifications" :key="cert.id" class="border border-slate-100 rounded-xl p-4">
            <h4 class="font-bold text-slate-800 text-sm">{{ cert.name }}</h4>
            <p class="text-xs text-slate-500 mt-0.5">{{ cert.issuing_organization }}</p>
            <p class="text-xs text-slate-400 mt-1">Issued {{ formatDate(cert.issue_date) }}</p>
          </div>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <footer class="border-t border-slate-200 bg-white">
      <div class="max-w-4xl mx-auto px-6 py-5 text-center text-xs text-slate-400">
        Generated with Portfolio Resume Generator
      </div>
    </footer>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  resume: Object,
  profileData: Object,
  selectedSkills: Array,
  selectedExperiences: Array,
  selectedProjects: Array,
  education: Array,
  certifications: Array,
  contactItems: Array,
});

const downloadUrl = computed(() => `/api/resumes/${props.resume.access_token}/download`);

const groupedSkills = computed(() => {
  return props.selectedSkills.reduce((acc, skill) => {
    const cat = skill.category || 'Other';
    if (!acc[cat]) acc[cat] = [];
    acc[cat].push(skill);
    return acc;
  }, {});
});

const formatDate = (d) => {
  if (!d) return '';
  const date = new Date(d);
  return date.toLocaleDateString('en-US', { year: 'numeric', month: 'short' });
};
</script>
