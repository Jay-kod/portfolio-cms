<template>
  <AdminCrudPage title="Projects" singularTitle="Project" subtitle="Showcase your best work and contributions" :items="projects" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">🚀</span>
    </template>
    <template #default="{ items }">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        <div v-for="proj in items" :key="proj.id" class="rounded-xl overflow-hidden hover:shadow-md transition" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
          <div class="h-32 relative flex items-center justify-center" style="background: var(--bg-tertiary);">
            <img v-if="proj.image_url" :src="proj.image_url" class="w-full h-full object-cover">
            <span v-else class="font-bold text-xs uppercase tracking-wider" style="color: var(--text-secondary);">{{ proj.title }}</span>
            <div class="absolute top-2 right-2 px-2 py-0.5 rounded-full text-xs font-bold shadow-sm" style="background: var(--bg-secondary); color: var(--text-primary);">{{ proj.project_type }}</div>
          </div>
          <div class="p-4">
            <h3 class="font-bold" style="color: var(--text-primary);">{{ proj.title }}</h3>
            <p class="text-sm line-clamp-2 mt-1" style="color: var(--text-secondary);">{{ proj.description }}</p>
            <div class="mt-3 flex justify-end gap-3 text-sm">
              <button @click="openModal(proj)" class="font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='var(--accent)'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Edit</button>
              <button @click="deleteItem(proj.id)" class="font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='#f43f5e'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AdminCrudPage>

  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-2xl p-6 max-h-[90vh] overflow-y-auto" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Project</h3>
      <form @submit.prevent="saveItem" class="space-y-4">
        <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Title</label>
          <input v-model="form.title" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required></div>
        <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Description</label>
          <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></textarea></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Type</label>
            <select v-model="form.project_type" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"><option>Professional</option><option>Personal</option><option>Open Source</option></select></div>
          <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Role</label>
            <input v-model="form.role" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></div>
        </div>
        <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Technologies (comma separated)</label>
          <input v-model="techInput" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Laravel, React, Docker"></div>
        <div class="grid grid-cols-2 gap-4">
          <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">GitHub URL</label>
            <input v-model="form.github_url" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></div>
          <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Live URL</label>
            <input v-model="form.live_url" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></div>
        </div>
        <div class="flex gap-6">
          <label class="flex items-center gap-2"><input type="checkbox" v-model="form.is_featured" class="w-4 h-4 rounded" style="accent-color: var(--accent);"><span class="text-sm" style="color: var(--text-primary);">Featured</span></label>
          <label class="flex items-center gap-2"><input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded" style="accent-color: var(--accent);"><span class="text-sm" style="color: var(--text-primary);">Active</span></label>
        </div>
        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl text-sm font-medium" style="color: var(--text-secondary); border: 1px solid var(--border-color);">Cancel</button>
          <button type="submit" :disabled="form.processing" class="px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md" style="background: var(--accent); color: #000;">{{ form.processing ? 'Saving...' : 'Save' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminCrudPage from '@/Components/AdminCrudPage.vue';

const props = defineProps({ projects: Array });
const showModal = ref(false);
const techInput = ref('');

const form = useForm({ id: null, title: '', description: '', project_type: 'Professional', technologies: [], role: '', team_size: null, start_date: '', end_date: '', is_ongoing: false, github_url: '', live_url: '', image_url: '', highlights: [], is_featured: false, is_active: true });

const openModal = (proj = null) => {
  if (proj) { Object.keys(form.data()).forEach(k => { if (k !== 'id') form[k] = proj[k] ?? form[k]; }); form.id = proj.id; techInput.value = (proj.technologies || []).join(', '); }
  else { form.reset(); form.id = null; techInput.value = ''; }
  showModal.value = true;
};

const saveItem = () => {
  form.technologies = techInput.value.split(',').map(t => t.trim()).filter(Boolean);
  const opts = { onSuccess: () => { showModal.value = false; } };
  form.id ? form.put(route('admin.projects.update', form.id), opts) : form.post(route('admin.projects.store'), opts);
};

const deleteItem = (id) => { if (confirm('Delete this project?')) router.delete(route('admin.projects.destroy', id)); };
</script>
