<template>
  <AdminCrudPage title="Profile & About" singularTitle="Item" subtitle="Manage bio, highlights, quick facts, and all About page content" :items="sections" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">👤</span>
    </template>
    <template #default="{ items }">
      <!-- Group by section_name type -->
      <div v-for="group in groupedItems(items)" :key="group.key" style="border-bottom: 1px solid var(--border-color);">
        <div class="px-6 py-3" style="background: var(--bg-tertiary); border-bottom: 1px solid var(--border-color);">
          <h3 class="text-xs font-bold tracking-widest uppercase" style="color: var(--text-secondary);">{{ group.label }} <span class="font-normal" style="color: var(--text-secondary);">({{ group.items.length }})</span></h3>
        </div>
        <div>
          <div v-for="s in group.items" :key="s.id" class="px-6 py-4 transition flex justify-between items-start gap-4" style="border-bottom: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
            <div class="flex items-start gap-3 flex-1 min-w-0">
              <span v-if="s.metadata?.emoji" class="text-xl mt-0.5">{{ s.metadata.emoji }}</span>
              <div class="min-w-0">
                <div class="font-semibold" style="color: var(--text-primary);">
                  <span v-if="s.title">{{ s.title }}</span>
                  <span v-else class="capitalize">{{ s.section_name.replace('_', ' ') }}</span>
                </div>
                <p class="text-sm mt-0.5 line-clamp-1" style="color: var(--text-secondary);">{{ s.content }}</p>
                <div class="flex items-center gap-2 mt-1">
                  <span class="text-xs px-2 py-0.5 rounded font-medium" style="background: var(--accent); color: #000; opacity: 0.85;">{{ s.section_name }}</span>
                  <span v-if="!s.is_active" class="text-xs bg-red-500/15 text-red-400 px-2 py-0.5 rounded font-medium">Inactive</span>
                </div>
              </div>
            </div>
            <div class="flex gap-2 flex-shrink-0">
              <button @click="openModal(s)" class="text-sm font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='var(--accent)'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Edit</button>
              <button @click="deleteItem(s.id)" class="text-sm font-medium" style="color: var(--text-secondary);" @mouseenter="$event.target.style.color='#f43f5e'" @mouseleave="$event.target.style.color='var(--text-secondary)'">Delete</button>
            </div>
          </div>
        </div>
      </div>
    </template>
  </AdminCrudPage>

  <!-- Modal -->
  <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm" @click.self="showModal = false">
    <div class="rounded-2xl shadow-2xl w-full max-w-lg p-6 max-h-[90vh] overflow-y-auto" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
      <h3 class="text-xl font-bold mb-6" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Item</h3>
      <form @submit.prevent="saveItem" class="space-y-4">
        <!-- Section Type -->
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Type</label>
          <select v-model="form.section_name" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
            <option value="bio">Bio</option>
            <option value="objective">Objective / Mission</option>
            <option value="highlight">Highlight (What I Do)</option>
            <option value="quick_fact">Quick Fact</option>
            <option value="custom">Custom Section</option>
          </select>
        </div>

        <!-- Title (for highlight, quick_fact, custom) -->
        <div v-if="form.section_name !== 'bio' && form.section_name !== 'objective'">
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Title</label>
          <input v-model="form.title" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                 :placeholder="form.section_name === 'quick_fact' ? 'e.g. Primary Stack' : 'e.g. Full Stack Development'" required>
        </div>

        <!-- Content -->
        <div>
          <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">
            {{ form.section_name === 'quick_fact' ? 'Value' : 'Content' }}
          </label>
          <textarea v-if="form.section_name === 'bio' || form.section_name === 'objective' || form.section_name === 'custom'"
                    v-model="form.content" rows="4"
                    class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required></textarea>
          <input v-else v-model="form.content"
                 class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                 :placeholder="form.section_name === 'quick_fact' ? 'e.g. Laravel + Vue.js + Tailwind' : 'Brief description'"
                 required>
        </div>

        <!-- Emoji (for highlights and quick facts) -->
        <div v-if="form.section_name === 'highlight' || form.section_name === 'quick_fact'" class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Emoji Icon</label>
            <input v-model="emojiInput" class="w-full px-4 py-2.5 rounded-xl text-2xl text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);"
                   placeholder="🚀" maxlength="4">
          </div>
          <div v-if="form.section_name === 'highlight'">
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Badge Color</label>
            <select v-model="iconBgInput" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
              <option value="bg-violet-100">Violet</option>
              <option value="bg-pink-100">Pink</option>
              <option value="bg-sky-100">Sky</option>
              <option value="bg-amber-100">Amber</option>
              <option value="bg-emerald-100">Emerald</option>
              <option value="bg-red-100">Red</option>
              <option value="bg-indigo-100">Indigo</option>
              <option value="bg-orange-100">Orange</option>
            </select>
          </div>
        </div>

        <!-- Order + Active -->
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1" style="color: var(--text-primary);">Display Order</label>
            <input type="number" v-model="form.display_order" class="w-full px-4 py-2.5 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
          </div>
          <div class="flex items-end">
            <label class="flex items-center gap-2 cursor-pointer">
              <input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
              <span class="text-sm font-medium" style="color: var(--text-primary);">Active</span>
            </label>
          </div>
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
import { ref } from 'vue';
import { useForm, router } from '@inertiajs/vue3';
import AdminCrudPage from '@/Components/AdminCrudPage.vue';

const props = defineProps({ sections: Array });
const showModal = ref(false);
const emojiInput = ref('');
const iconBgInput = ref('bg-violet-100');

const form = useForm({
  id: null,
  section_name: 'highlight',
  title: '',
  content: '',
  metadata: null,
  is_active: true,
  display_order: 0,
});

const groupedItems = (items) => {
  const order = ['bio', 'objective', 'highlight', 'quick_fact', 'custom'];
  const labels = {
    bio: 'Bio',
    objective: 'Mission / Objective',
    highlight: 'Highlights (What I Do)',
    quick_fact: 'Quick Facts',
    custom: 'Custom Sections',
  };
  const groups = {};
  items.forEach(item => {
    const key = order.includes(item.section_name) ? item.section_name : 'custom';
    if (!groups[key]) groups[key] = [];
    groups[key].push(item);
  });
  return order
    .filter(k => groups[k]?.length)
    .map(k => ({ key: k, label: labels[k] || k, items: groups[k] }));
};

const openModal = (s = null) => {
  if (s) {
    form.id = s.id;
    form.section_name = s.section_name;
    form.title = s.title || '';
    form.content = s.content;
    form.metadata = s.metadata;
    form.is_active = s.is_active;
    form.display_order = s.display_order;
    emojiInput.value = s.metadata?.emoji || '';
    iconBgInput.value = s.metadata?.iconBg || 'bg-violet-100';
  } else {
    form.reset();
    form.id = null;
    form.section_name = 'highlight';
    emojiInput.value = '';
    iconBgInput.value = 'bg-violet-100';
  }
  showModal.value = true;
};

const saveItem = () => {
  // Build metadata from inputs
  if (form.section_name === 'highlight') {
    form.metadata = { emoji: emojiInput.value, iconBg: iconBgInput.value };
  } else if (form.section_name === 'quick_fact') {
    form.metadata = { emoji: emojiInput.value };
  } else {
    form.metadata = null;
  }

  // For bio/objective, set title from section_name
  if (form.section_name === 'bio' || form.section_name === 'objective') {
    form.title = '';
  }

  const opts = { onSuccess: () => { showModal.value = false; } };
  if (form.id) {
    form.put(route('admin.profile-sections.update', form.id), opts);
  } else {
    form.post(route('admin.profile-sections.store'), opts);
  }
};

const deleteItem = (id) => {
  if (confirm('Delete this item?')) router.delete(route('admin.profile-sections.destroy', id));
};
</script>
