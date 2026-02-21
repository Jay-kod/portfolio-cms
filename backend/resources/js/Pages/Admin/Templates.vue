<template>
  <AdminCrudPage title="Resume Templates" singularTitle="Template" subtitle="Configure and manage resume layout templates" :items="templates" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">📐</span>
    </template>
    <template #default="{ items }">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
        <div v-for="tpl in items" :key="tpl.id" class="rounded-xl overflow-hidden hover:shadow-md transition" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
          <div class="h-36 flex items-center justify-center font-bold text-xs uppercase tracking-widest" style="background: var(--bg-tertiary); color: var(--text-secondary);">
            {{ tpl.name }}
          </div>
          <div class="p-4">
            <h3 class="font-bold" style="color: var(--text-primary);">{{ tpl.name }}</h3>
            <p class="text-sm line-clamp-2 mt-1" style="color: var(--text-secondary);">{{ tpl.description }}</p>
            <div class="mt-3 flex justify-end gap-3 text-sm">
              <button @click="openModal(tpl)" class="font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='var(--accent)'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Edit</button>
              <button @click="deleteItem(tpl.id)" class="font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='#f43f5e'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AdminCrudPage>

  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Template</h3>
      <form @submit.prevent="saveItem" class="space-y-4">
        <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Name</label><input v-model="form.name" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required></div>
        <div><label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Description</label><textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"></textarea></div>
        <label class="flex items-center gap-2"><input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded" style="accent-color: var(--accent);"><span class="text-sm" style="color: var(--text-primary);">Active</span></label>
        <div class="flex justify-end gap-3 pt-4">
          <button type="button" @click="showModal = false" class="px-5 py-2.5 rounded-xl text-sm font-medium" style="color: var(--text-secondary); border: 1px solid var(--border-color);">Cancel</button>
          <button type="submit" :disabled="form.processing" class="px-5 py-2.5 rounded-xl text-sm font-semibold shadow-md" style="background: var(--accent); color: #000;">{{ form.processing ? 'Saving...' : 'Save' }}</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'; import { useForm, router } from '@inertiajs/vue3'; import AdminCrudPage from '@/Components/AdminCrudPage.vue';
const props = defineProps({ templates: Array }); const showModal = ref(false);
const form = useForm({ id: null, name: '', description: '', layout_config: {}, styling_config: {}, is_active: true, thumbnail_url: '' });
const openModal = (tpl = null) => { if (tpl) { Object.keys(form.data()).forEach(k => { if (k !== 'id') form[k] = tpl[k] ?? form[k]; }); form.id = tpl.id; } else { form.reset(); form.id = null; } showModal.value = true; };
const saveItem = () => { const opts = { onSuccess: () => { showModal.value = false; } }; form.id ? form.put(route('admin.templates.update', form.id), opts) : form.post(route('admin.templates.store'), opts); };
const deleteItem = (id) => { if (confirm('Delete?')) router.delete(route('admin.templates.destroy', id)); };
</script>
