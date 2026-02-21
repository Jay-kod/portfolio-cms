<template>
  <AdminCrudPage title="Experience" singularTitle="Experience" subtitle="Track your career journey and professional roles" :items="experiences" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">💼</span>
    </template>
    <template #default="{ items }">
      <div>
        <div v-for="exp in items" :key="exp.id" class="p-6 transition flex justify-between items-start gap-4" style="border-bottom: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <div class="flex-1">
            <div class="flex items-center gap-3 mb-1">
              <h3 class="font-bold" style="color: var(--text-primary);">{{ exp.job_title }}</h3>
              <span v-if="exp.is_current" class="text-xs bg-emerald-500/15 text-emerald-400 px-2 py-0.5 rounded-full font-medium">Current</span>
            </div>
            <div class="text-sm" style="color: var(--text-secondary);">{{ exp.company_name }} · {{ exp.company_location }}</div>
            <div class="text-xs mt-1" style="color: var(--text-secondary);">{{ exp.start_date?.substring(0,10) }} — {{ exp.is_current ? 'Present' : exp.end_date?.substring(0,10) }}</div>
          </div>
          <div class="flex gap-2">
            <button @click="openModal(exp)" class="text-sm font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='var(--accent)'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Edit</button>
            <button @click="deleteItem(exp.id)" class="text-sm font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='#f43f5e'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Delete</button>
          </div>
        </div>
      </div>
    </template>
  </AdminCrudPage>

  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Experience</h3>
      <form @submit.prevent="saveItem" class="space-y-4">
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Job Title</label>
            <input v-model="form.job_title" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Company</label>
            <input v-model="form.company_name" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Location</label>
            <input v-model="form.company_location" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Type</label>
            <select v-model="form.employment_type" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
              <option>Full-time</option><option>Part-time</option><option>Contract</option><option>Freelance</option>
            </select>
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Start Date</label>
            <input type="date" v-model="form.start_date" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">End Date</label>
            <input type="date" v-model="form.end_date" :disabled="form.is_current" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none disabled:opacity-50" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
          </div>
        </div>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="checkbox" v-model="form.is_current" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
          <span class="text-sm font-medium" style="color: var(--text-primary);">Currently working here</span>
        </label>
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Description</label>
          <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></textarea>
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Achievements (one per line)</label>
          <textarea v-model="achievementsInput" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Reduced API response time by 40%&#10;Led migration to Laravel 10"></textarea>
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Technologies (comma separated)</label>
          <input v-model="techInput" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Laravel, Vue.js, AWS">
        </div>
        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl text-sm font-medium" style="color: var(--text-secondary); border: 1px solid var(--border-color);">Cancel</button>
          <button type="submit" :disabled="form.processing" class="px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md" style="background: var(--accent); color: #000;">
            {{ form.processing ? 'Saving...' : 'Save' }}
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

const props = defineProps({ experiences: Array });
const showModal = ref(false);
const achievementsInput = ref('');
const techInput = ref('');

const form = useForm({
  id: null, job_title: '', company_name: '', company_location: '', employment_type: 'Full-time',
  start_date: '', end_date: '', is_current: false, description: '', achievements: [], technologies_used: [], display_order: 0, is_active: true,
});

const openModal = (exp = null) => {
  if (exp) {
    Object.assign(form, { id: exp.id, job_title: exp.job_title, company_name: exp.company_name, company_location: exp.company_location, employment_type: exp.employment_type, start_date: exp.start_date?.substring(0,10), end_date: exp.end_date?.substring(0,10), is_current: exp.is_current, description: exp.description, display_order: exp.display_order, is_active: exp.is_active });
    achievementsInput.value = (exp.achievements || []).join('\n');
    techInput.value = (exp.technologies_used || []).join(', ');
  } else { form.reset(); form.id = null; achievementsInput.value = ''; techInput.value = ''; }
  showModal.value = true;
};

const saveItem = () => {
  form.achievements = achievementsInput.value.split('\n').map(a => a.trim()).filter(Boolean);
  form.technologies_used = techInput.value.split(',').map(t => t.trim()).filter(Boolean);
  const opts = { onSuccess: () => { showModal.value = false; } };
  form.id ? form.put(route('admin.experiences.update', form.id), opts) : form.post(route('admin.experiences.store'), opts);
};

const deleteItem = (id) => { if (confirm('Delete this experience?')) router.delete(route('admin.experiences.destroy', id)); };
</script>
