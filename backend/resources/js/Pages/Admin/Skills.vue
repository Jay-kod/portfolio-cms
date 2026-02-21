<template>
  <AdminCrudPage title="Skills" singularTitle="Skill" subtitle="Manage your technical skills and proficiency levels" :items="skills" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">⚡</span>
    </template>
    <template #default="{ items }">
      <table class="w-full text-left">
        <thead class="text-xs uppercase font-semibold tracking-wider" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color); color: var(--text-secondary);">
          <tr>
            <th class="px-6 py-4">Name</th>
            <th class="px-6 py-4">Category</th>
            <th class="px-6 py-4">Proficiency</th>
            <th class="px-6 py-4">Years</th>
            <th class="px-6 py-4 text-right">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="skill in items" :key="skill.id" class="transition" style="border-bottom: 1px solid var(--border-color);"
              @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
              @mouseleave="$event.currentTarget.style.background = 'transparent'">
            <td class="px-6 py-4">
              <div class="font-semibold" style="color: var(--text-primary);">{{ skill.name }}</div>
              <div class="flex gap-1 mt-1">
                <span v-for="tag in skill.tags" :key="tag" class="text-xs px-1.5 py-0.5 rounded" style="background: var(--accent, #00ff88); opacity: 0.8; color: #000;">{{ tag }}</span>
              </div>
            </td>
            <td class="px-6 py-4"><span class="px-2.5 py-1 rounded-lg text-xs font-medium" style="background: var(--bg-tertiary); color: var(--text-secondary);">{{ skill.category }}</span></td>
            <td class="px-6 py-4">
              <div class="flex items-center gap-2">
                <div class="w-20 rounded-full h-1.5" style="background: var(--bg-tertiary);">
                  <div class="h-1.5 rounded-full" :style="`width:${skill.proficiency_level}%; background: var(--accent);`"></div>
                </div>
                <span class="text-xs" style="color: var(--text-secondary);">{{ skill.proficiency_level }}%</span>
              </div>
            </td>
            <td class="px-6 py-4 text-sm" style="color: var(--text-secondary);">{{ skill.years_of_experience }}y</td>
            <td class="px-6 py-4 text-right">
              <button @click="openModal(skill)" class="text-sm font-medium mr-3 transition" style="color: var(--text-secondary);"
                      @mouseenter="$event.target.style.color = 'var(--accent)'"
                      @mouseleave="$event.target.style.color = 'var(--text-secondary)'">Edit</button>
              <button @click="deleteItem(skill.id)" class="text-sm font-medium transition" style="color: var(--text-secondary);"
                      @mouseenter="$event.target.style.color = '#f43f5e'"
                      @mouseleave="$event.target.style.color = 'var(--text-secondary)'">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </template>
  </AdminCrudPage>

  <!-- Modal -->
  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Skill</h3>
      <form @submit.prevent="saveItem" class="space-y-4">
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Name</label>
          <input v-model="form.name" class="w-full px-4 py-2.5 rounded-xl border focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);" required>
          <div v-if="form.errors.name" class="text-red-400 text-xs mt-1">{{ form.errors.name }}</div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Category</label>
            <input v-model="form.category" list="category-list" placeholder="Select or type new category"
                   class="w-full px-4 py-2.5 rounded-xl border focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary);">
            <datalist id="category-list">
              <option v-for="cat in categories" :key="cat" :value="cat" />
            </datalist>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Proficiency (%)</label>
            <input type="number" v-model="form.proficiency_level" min="0" max="100" class="w-full px-4 py-2.5 rounded-xl border focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary);">
          </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Years of Experience</label>
            <input type="number" step="0.5" v-model="form.years_of_experience" class="w-full px-4 py-2.5 rounded-xl border focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary);">
          </div>
          <div class="flex items-end">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.is_featured" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
              <span class="text-sm font-medium" style="color: var(--text-primary);">Featured</span>
            </label>
          </div>
        </div>
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Tags (comma separated)</label>
          <input v-model="tagsInput" class="w-full px-4 py-2.5 rounded-xl border focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border-color: var(--border-color); color: var(--text-primary);" placeholder="backend, language, framework">
        </div>
        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl text-sm font-medium transition" style="color: var(--text-secondary); border: 1px solid var(--border-color);">Cancel</button>
          <button type="submit" :disabled="form.processing"
                  class="px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-md" style="background: var(--accent); color: #000;">
            {{ form.processing ? 'Saving...' : 'Save' }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminCrudPage from '@/Components/AdminCrudPage.vue';

const props = defineProps({ skills: Array, categories: Array });
const showModal = ref(false);
const tagsInput = ref('');

const form = useForm({
  id: null,
  name: '',
  category: '',
  proficiency_level: 80,
  years_of_experience: 1,
  is_featured: false,
  tags: [],
});

const openModal = (skill = null) => {
  if (skill) {
    form.id = skill.id;
    form.name = skill.name;
    form.category = skill.category;
    form.proficiency_level = skill.proficiency_level;
    form.years_of_experience = skill.years_of_experience;
    form.is_featured = skill.is_featured;
    form.tags = skill.tags || [];
    tagsInput.value = (skill.tags || []).join(', ');
  } else {
    form.reset();
    form.id = null;
    tagsInput.value = '';
  }
  showModal.value = true;
};

const saveItem = () => {
  form.tags = tagsInput.value.split(',').map(t => t.trim()).filter(Boolean);
  if (form.id) {
    form.put(route('admin.skills.update', form.id), { onSuccess: () => { showModal.value = false; } });
  } else {
    form.post(route('admin.skills.store'), { onSuccess: () => { showModal.value = false; } });
  }
};

const deleteItem = (id) => {
  if (confirm('Delete this skill?')) {
    router.delete(route('admin.skills.destroy', id));
  }
};
</script>
