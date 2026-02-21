<template>
  <ResumeLayout :step="currentStep" :totalSteps="3">
    <!-- Step 1: Job Details -->
    <div v-if="currentStep === 1" class="max-w-2xl mx-auto animate-fade-in">
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-8 md:p-10">
        <div class="text-center mb-8">
          <div class="w-16 h-16 bg-violet-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
          </div>
          <h1 class="text-3xl font-black text-slate-900 mb-2">Tailor Your Resume</h1>
          <p class="text-slate-500">Describe the job you're targeting and we'll intelligently select the best content from the portfolio.</p>
        </div>

        <form @submit.prevent="analyzeJob" class="space-y-6">
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Job Title <span class="text-red-500">*</span></label>
            <input type="text" v-model="jobData.job_title"
                   class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition text-lg"
                   placeholder="e.g. Senior Full Stack Developer" required>
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Company Name</label>
            <input type="text" v-model="jobData.company_name"
                   class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                   placeholder="e.g. Google, Meta, Startup Inc.">
          </div>
          <div>
            <label class="block text-sm font-semibold text-slate-700 mb-2">Job Description</label>
            <textarea v-model="jobData.job_description" rows="7"
                      class="w-full px-4 py-3.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 transition"
                      placeholder="Paste the full job description here for best results..."></textarea>
            <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
              We analyze keywords to highlight the most relevant skills and experience.
            </p>
          </div>

          <button type="submit"
                  class="w-full bg-gradient-to-r from-violet-600 to-purple-600 text-white py-4 rounded-2xl font-bold text-lg hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-3"
                  :disabled="loading">
            <span v-if="!loading">Analyze & Continue</span>
            <template v-else>
              <span class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span>
              <span>Analyzing...</span>
            </template>
          </button>
        </form>
      </div>
    </div>

    <!-- Step 2: Content Selection -->
    <div v-if="currentStep === 2" class="grid grid-cols-1 lg:grid-cols-3 gap-8 animate-fade-in">
      <div class="lg:col-span-2 space-y-6">
        <!-- Skills -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
          <div class="flex items-center justify-between mb-5">
            <h3 class="text-lg font-bold text-slate-800">Skills</h3>
            <span class="text-xs font-medium bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full">
              AI-ranked by relevance
            </span>
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <label v-for="skill in analysisData.skills" :key="skill.id"
                   class="relative flex items-center p-3 rounded-xl border-2 cursor-pointer hover:bg-slate-50 transition-all duration-200"
                   :class="isSelected('skills', skill.id) ? 'border-violet-500 bg-violet-50/50 shadow-sm' : 'border-slate-100'">
              <input type="checkbox" :value="skill.id" v-model="selected.skills" class="sr-only">
              <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-slate-800 truncate flex items-center gap-1.5">
                  <svg v-if="isSelected('skills', skill.id)" class="w-4 h-4 text-violet-600 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                  <span class="w-4 h-4 border-2 border-slate-300 rounded-full flex-shrink-0" v-else></span>
                  {{ skill.name }}
                </div>
                <div class="text-xs text-slate-400 mt-0.5">{{ skill.proficiency_level }}% · {{ skill.years_of_experience }}y</div>
              </div>
              <div v-if="skill.auto_selected" class="absolute -top-1 -right-1 w-3 h-3 bg-emerald-500 rounded-full border-2 border-white" title="Recommended"></div>
            </label>
          </div>
        </div>

        <!-- Experience -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
          <h3 class="text-lg font-bold text-slate-800 mb-5">Experience</h3>
          <div class="space-y-3">
            <label v-for="exp in analysisData.experiences" :key="exp.id"
                   class="flex items-start p-4 rounded-xl border-2 cursor-pointer hover:bg-slate-50 transition-all duration-200"
                   :class="isSelected('experiences', exp.id) ? 'border-violet-500 bg-violet-50/50 shadow-sm' : 'border-slate-100'">
              <input type="checkbox" :value="exp.id" v-model="selected.experiences" class="sr-only">
              <div class="mr-3 mt-0.5">
                <svg v-if="isSelected('experiences', exp.id)" class="w-5 h-5 text-violet-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <span v-else class="w-5 h-5 border-2 border-slate-300 rounded-full block"></span>
              </div>
              <div class="flex-1">
                <div class="flex items-center justify-between gap-2">
                  <h4 class="font-bold text-slate-800">{{ exp.job_title }}</h4>
                  <span v-if="exp.is_current" class="text-xs bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full">Current</span>
                </div>
                <div class="text-sm text-slate-500">{{ exp.company_name }}</div>
                <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ exp.description }}</p>
              </div>
            </label>
          </div>
        </div>

        <!-- Projects -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
          <h3 class="text-lg font-bold text-slate-800 mb-5">Projects</h3>
          <div class="space-y-3">
            <label v-for="proj in analysisData.projects" :key="proj.id"
                   class="flex items-start p-4 rounded-xl border-2 cursor-pointer hover:bg-slate-50 transition-all duration-200"
                   :class="isSelected('projects', proj.id) ? 'border-violet-500 bg-violet-50/50 shadow-sm' : 'border-slate-100'">
              <input type="checkbox" :value="proj.id" v-model="selected.projects" class="sr-only">
              <div class="mr-3 mt-0.5">
                <svg v-if="isSelected('projects', proj.id)" class="w-5 h-5 text-violet-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>
                <span v-else class="w-5 h-5 border-2 border-slate-300 rounded-full block"></span>
              </div>
              <div class="flex-1">
                <h4 class="font-bold text-slate-800">{{ proj.title }}</h4>
                <p class="text-xs text-slate-400 mt-1 line-clamp-2">{{ proj.description }}</p>
                <div class="flex flex-wrap gap-1 mt-2">
                  <span v-for="tech in proj.technologies" :key="tech" class="text-xs bg-slate-100 text-slate-500 px-1.5 py-0.5 rounded">{{ tech }}</span>
                </div>
              </div>
            </label>
          </div>
        </div>
      </div>

      <!-- Sidebar: Template + Generate -->
      <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
          <h3 class="text-lg font-bold text-slate-800 mb-5">Choose Template</h3>
          <div class="space-y-3 mb-6">
            <label v-for="tpl in templates" :key="tpl.id" class="block cursor-pointer">
              <input type="radio" :value="tpl.id" v-model="selectedTemplateId" class="peer sr-only">
              <div class="border-2 rounded-xl p-4 hover:border-violet-300 peer-checked:border-violet-500 peer-checked:bg-violet-50 transition-all">
                <div class="h-20 bg-gradient-to-br from-slate-100 to-slate-200 rounded-lg mb-3 flex items-center justify-center text-slate-400 text-xs uppercase tracking-wider font-bold">
                  {{ tpl.name }}
                </div>
                <div class="font-semibold text-sm text-slate-800">{{ tpl.name }}</div>
                <div class="text-xs text-slate-500 mt-0.5">{{ tpl.description }}</div>
              </div>
            </label>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold text-slate-700 mb-2">Custom Objective (optional)</label>
            <textarea v-model="customObjective" rows="4"
                      class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm focus:ring-2 focus:ring-violet-500 focus:border-violet-500"
                      placeholder="Write a custom objective statement..."></textarea>
          </div>

          <div class="space-y-3">
            <div class="text-xs text-slate-400 mb-2 text-center">
              {{ selected.skills.length }} skills · {{ selected.experiences.length }} experiences · {{ selected.projects.length }} projects
            </div>
            <button @click="generateResume"
                    class="w-full bg-gradient-to-r from-violet-600 to-purple-600 text-white py-3.5 rounded-xl font-bold hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2"
                    :disabled="loading || !selectedTemplateId">
              <span v-if="!loading">Generate Resume</span>
              <template v-else>
                <span class="animate-spin rounded-full h-5 w-5 border-b-2 border-white"></span>
                <span>Generating...</span>
              </template>
            </button>
            <button @click="currentStep = 1" class="w-full text-slate-500 text-sm hover:text-slate-700 py-2">
              &larr; Back to Job Details
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Step 3: Success -->
    <div v-if="currentStep === 3" class="max-w-2xl mx-auto text-center animate-fade-in">
      <div class="bg-white rounded-2xl shadow-lg border border-slate-100 p-10">
        <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-6">
          <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
          </svg>
        </div>
        <h2 class="text-3xl font-black text-slate-900 mb-3">Resume Generated!</h2>
        <p class="text-slate-500 mb-8 max-w-md mx-auto">Your tailored resume is ready. View it, download the PDF, or share the link.</p>

        <div class="bg-slate-50 p-5 rounded-xl border border-slate-200 mb-8">
          <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Shareable Link</label>
          <div class="flex gap-2">
            <input type="text" :value="generatedUrl" readonly
                   class="flex-1 bg-white border border-slate-200 rounded-lg px-3 py-2.5 text-sm text-slate-600 font-mono">
            <button @click="copyLink"
                    class="bg-violet-600 hover:bg-violet-700 text-white px-4 py-2.5 rounded-lg text-sm font-medium transition flex items-center gap-1.5">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" /></svg>
              {{ copied ? 'Copied!' : 'Copy' }}
            </button>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a :href="viewUrl" target="_blank"
             class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-slate-200 rounded-xl font-semibold text-slate-700 hover:bg-slate-50 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
            Preview
          </a>
          <a :href="downloadUrl"
             class="inline-flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-violet-600 to-purple-600 text-white rounded-xl font-bold hover:from-violet-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-xl">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
            Download PDF
          </a>
        </div>

        <button @click="resetForm" class="mt-10 text-violet-600 hover:text-violet-700 font-medium text-sm hover:underline">
          &larr; Create Another Resume
        </button>
      </div>
    </div>
  </ResumeLayout>
</template>

<script setup>
import { ref, reactive } from 'vue';
import { router } from '@inertiajs/vue3';
import ResumeLayout from '@/Layouts/ResumeLayout.vue';
import axios from 'axios';

const props = defineProps({
  templates: Array,
});

const currentStep = ref(1);
const loading = ref(false);
const copied = ref(false);

const jobData = reactive({ job_title: '', company_name: '', job_description: '' });
const analysisData = reactive({ skills: [], experiences: [], projects: [] });
const selected = reactive({ skills: [], experiences: [], projects: [], education: [], certifications: [] });
const selectedTemplateId = ref(props.templates?.[0]?.id || null);
const customObjective = ref('');
const generatedToken = ref('');

const generatedUrl = ref('');
const viewUrl = ref('');
const downloadUrl = ref('');

const isSelected = (type, id) => selected[type].includes(id);

const analyzeJob = async () => {
  loading.value = true;
  try {
    const res = await axios.post('/api/resumes/analyze', jobData);
    Object.assign(analysisData, res.data);
    // Auto-select recommended items
    selected.skills = analysisData.skills.filter(i => i.auto_selected).map(i => i.id);
    selected.experiences = analysisData.experiences.filter(i => i.auto_selected).map(i => i.id);
    selected.projects = analysisData.projects.filter(i => i.auto_selected).map(i => i.id);
    // Fetch education/certs and auto-select all
    const portfolio = await axios.get('/api/portfolio/full');
    selected.education = portfolio.data.education.map(e => e.id);
    selected.certifications = portfolio.data.certifications.map(c => c.id);
    currentStep.value = 2;
  } catch (e) {
    alert('Error analyzing job. Please try again.');
  } finally {
    loading.value = false;
  }
};

const generateResume = async () => {
  loading.value = true;
  try {
    const payload = {
      ...jobData,
      template_id: selectedTemplateId.value,
      selected_skills: selected.skills,
      selected_experiences: selected.experiences,
      selected_projects: selected.projects,
      selected_education: selected.education,
      selected_certifications: selected.certifications,
      custom_objective: customObjective.value,
    };
    const res = await axios.post('/api/resumes/generate', payload);
    generatedToken.value = res.data.token;
    generatedUrl.value = `${window.location.origin}/resume/${res.data.token}`;
    viewUrl.value = `/api/resumes/${res.data.token}`;
    downloadUrl.value = `/api/resumes/${res.data.token}/download`;
    currentStep.value = 3;
  } catch (e) {
    alert('Error generating resume. Please try again.');
  } finally {
    loading.value = false;
  }
};

const copyLink = () => {
  navigator.clipboard.writeText(generatedUrl.value);
  copied.value = true;
  setTimeout(() => copied.value = false, 2000);
};

const resetForm = () => {
  currentStep.value = 1;
  jobData.job_title = ''; jobData.company_name = ''; jobData.job_description = '';
  selected.skills = []; selected.experiences = []; selected.projects = []; selected.education = []; selected.certifications = [];
  customObjective.value = '';
  generatedToken.value = '';
};
</script>

<style scoped>
.animate-fade-in {
  animation: fadeIn 0.3s ease-out;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(8px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
