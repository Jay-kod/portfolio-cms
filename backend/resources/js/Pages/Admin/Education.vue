<template>
  <AdminCrudPage title="Education" singularTitle="Education" subtitle="Record your academic background and qualifications" :items="education" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">🎓</span>
    </template>
    <template #default="{ items }">
      <div>
        <div v-for="edu in items" :key="edu.id" class="p-6 transition flex justify-between items-start gap-4" style="border-bottom: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <div class="flex items-start gap-4 flex-1 min-w-0">
            <!-- Icon -->
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--bg-tertiary);">
              <svg class="w-5 h-5" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" /></svg>
            </div>
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 flex-wrap">
                <h3 class="font-bold" style="color: var(--text-primary);">{{ edu.degree }} <span class="font-normal" style="color: var(--text-secondary);">in</span> {{ edu.field_of_study }}</h3>
                <span v-if="edu.is_current" class="text-[10px] bg-emerald-500/15 text-emerald-400 px-2 py-0.5 rounded-full font-bold uppercase tracking-wider flex items-center gap-1">
                  <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                  Current
                </span>
              </div>
              <div class="text-sm mt-0.5 flex items-center gap-2 flex-wrap" style="color: var(--text-secondary);">
                <span class="flex items-center gap-1">
                  <svg class="w-3.5 h-3.5" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                  {{ edu.institution_name }}
                </span>
                <span v-if="edu.location" class="flex items-center gap-1" style="color: var(--text-secondary);">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                  {{ edu.location }}
                </span>
              </div>
              <div class="flex items-center gap-3 mt-1.5 flex-wrap">
                <span class="text-xs flex items-center gap-1" style="color: var(--text-secondary);">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                  {{ edu.start_date?.substring(0,10) }} — {{ edu.is_current ? 'Present' : edu.end_date?.substring(0,10) }}
                </span>
                <span v-if="edu.grade" class="text-xs font-semibold text-emerald-400 bg-emerald-500/15 px-2 py-0.5 rounded-full flex items-center gap-1">
                  <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4" /></svg>
                  {{ edu.grade }}
                </span>
              </div>
              <div v-if="edu.achievements?.length" class="mt-2 flex items-center gap-1.5">
                <span class="text-xs" style="color: var(--text-secondary);">{{ edu.achievements.length }} achievement{{ edu.achievements.length > 1 ? 's' : '' }}</span>
              </div>
            </div>
          </div>
          <div class="flex gap-1 flex-shrink-0">
            <button @click="openModal(edu)" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.color='var(--accent)';$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.color='var(--text-secondary)';$event.currentTarget.style.background=''" title="Edit">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </button>
            <button @click="deleteItem(edu.id)" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.color='#f43f5e';$event.currentTarget.style.background='rgba(244,63,94,0.1)'" @mouseleave="$event.currentTarget.style.color='var(--text-secondary)';$event.currentTarget.style.background=''" title="Delete">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
            </button>
          </div>
        </div>
      </div>
    </template>
  </AdminCrudPage>

  <!-- Modal -->
  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <!-- Modal header -->
      <div class="sticky top-0 z-10 px-6 py-4 flex items-center justify-between rounded-t-2xl" style="background: var(--bg-secondary); border-bottom: 1px solid var(--border-color);">
        <div>
          <h3 class="text-xl font-bold" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Education</h3>
          <p class="text-sm mt-0.5" style="color: var(--text-secondary);">{{ form.id ? 'Update education details' : 'Add a new academic qualification' }}</p>
        </div>
        <button @click="showModal = false" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form @submit.prevent="saveItem" class="p-6 space-y-5">
        <!-- Institution -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Institution Name <span class="text-red-400">*</span></label>
          <input v-model="form.institution_name" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. MIT, Stanford University" required>
        </div>

        <!-- Degree & Field -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Degree <span class="text-red-400">*</span></label>
            <input v-model="form.degree" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. Bachelor of Science" required>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Field of Study <span class="text-red-400">*</span></label>
            <input v-model="form.field_of_study" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. Computer Science" required>
          </div>
        </div>

        <!-- Location -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Location</label>
          <input v-model="form.location" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. Cambridge, MA, USA">
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Start Date <span class="text-red-400">*</span></label>
            <input type="date" v-model="form.start_date" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">End Date</label>
            <input type="date" v-model="form.end_date" :disabled="form.is_current" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition disabled:opacity-50 disabled:cursor-not-allowed" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
          </div>
        </div>

        <!-- Currently studying -->
        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl transition" style="border: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <input type="checkbox" v-model="form.is_current" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
          <div>
            <span class="text-sm font-semibold" style="color: var(--text-primary);">Currently studying here</span>
            <p class="text-xs mt-0.5" style="color: var(--text-secondary);">End date will be set to "Present"</p>
          </div>
        </label>

        <!-- Grade -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Grade / GPA</label>
          <input v-model="form.grade" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. 3.8/4.0, First Class Honours">
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Description</label>
          <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition resize-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Brief description of your studies, thesis, or program focus..."></textarea>
        </div>

        <!-- Achievements -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Achievements <span class="text-xs font-normal" style="color: var(--text-secondary);">(one per line)</span></label>
          <textarea v-model="achievementsInput" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition resize-none font-mono text-sm" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Dean's List 2023&#10;Best Thesis Award&#10;Published 2 research papers"></textarea>
        </div>

        <!-- Active toggle -->
        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl transition" style="border: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
          <div>
            <span class="text-sm font-semibold" style="color: var(--text-primary);">Active</span>
            <p class="text-xs mt-0.5" style="color: var(--text-secondary);">Show this entry on your public portfolio</p>
          </div>
        </label>

        <!-- Actions -->
        <div class="flex justify-end gap-3 pt-4" style="border-top: 1px solid var(--border-color);">
          <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl text-sm font-medium transition" style="color: var(--text-secondary); border: 1px solid var(--border-color);">Cancel</button>
          <button type="submit" :disabled="form.processing"
                  class="px-6 py-2.5 rounded-xl text-sm font-semibold shadow-md disabled:opacity-50 disabled:cursor-not-allowed transition flex items-center gap-2" style="background: var(--accent); color: #000;">
            <svg v-if="form.processing" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            {{ form.processing ? 'Saving...' : (form.id ? 'Update' : 'Create') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminCrudPage from '@/Components/AdminCrudPage.vue';

const props = defineProps({ education: Array });
const showModal = ref(false);
const achievementsInput = ref('');

const form = useForm({
  id: null,
  institution_name: '',
  degree: '',
  field_of_study: '',
  location: '',
  start_date: '',
  end_date: '',
  is_current: false,
  grade: '',
  description: '',
  achievements: [],
  is_active: true,
});

const openModal = (edu = null) => {
  if (edu) {
    Object.keys(form.data()).forEach(k => {
      if (k !== 'id') form[k] = edu[k] ?? form[k];
    });
    form.id = edu.id;
    form.start_date = edu.start_date?.substring(0, 10) || '';
    form.end_date = edu.end_date?.substring(0, 10) || '';
    achievementsInput.value = (edu.achievements || []).join('\n');
  } else {
    form.reset();
    form.id = null;
    achievementsInput.value = '';
  }
  showModal.value = true;
};

const saveItem = () => {
  form.achievements = achievementsInput.value.split('\n').map(a => a.trim()).filter(Boolean);
  const opts = { onSuccess: () => { showModal.value = false; } };
  form.id
    ? form.put(route('admin.education.update', form.id), opts)
    : form.post(route('admin.education.store'), opts);
};

const deleteItem = (id) => {
  if (confirm('Delete this education entry?')) {
    router.delete(route('admin.education.destroy', id));
  }
};
</script>
