<template>
  <AdminCrudPage title="Certifications" singularTitle="Certification" subtitle="Keep track of your professional credentials" :items="certifications" @create="openModal()">
    <template #hero-icon>
      <span class="text-2xl select-none">🏅</span>
    </template>
    <template #default="{ items }">
      <div>
        <div v-for="cert in items" :key="cert.id" class="p-6 transition flex justify-between items-start gap-4" style="border-bottom: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <div class="flex items-start gap-4 flex-1 min-w-0">
            <!-- Badge Icon -->
            <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--bg-tertiary);">
              <svg class="w-5 h-5" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" /></svg>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="font-bold" style="color: var(--text-primary);">{{ cert.name }}</h3>
              <div class="text-sm mt-0.5" style="color: var(--text-secondary);">{{ cert.issuing_organization }}</div>
              <div class="flex items-center gap-2 mt-2 flex-wrap">
                <span class="text-xs px-2 py-0.5 rounded-full" style="color: var(--text-secondary); background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                  Issued {{ cert.issue_date?.substring(0, 10) }}
                </span>
                <span v-if="cert.expiry_date && new Date(cert.expiry_date) > new Date()" class="text-xs text-emerald-400 bg-emerald-500/15 px-2 py-0.5 rounded-full flex items-center gap-1">
                  <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Valid
                </span>
                <span v-else-if="cert.expiry_date && new Date(cert.expiry_date) <= new Date()" class="text-xs text-red-400 bg-red-500/15 px-2 py-0.5 rounded-full">
                  Expired
                </span>
                <span v-else class="text-xs text-emerald-400 bg-emerald-500/15 px-2 py-0.5 rounded-full flex items-center gap-1">
                  <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> No Expiry
                </span>
              </div>
              <div v-if="cert.credential_id" class="text-xs mt-1.5" style="color: var(--text-secondary);">
                ID: <span class="font-mono" style="color: var(--text-secondary);">{{ cert.credential_id }}</span>
              </div>
            </div>
          </div>
          <div class="flex gap-1 flex-shrink-0">
            <button @click="openModal(cert)" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.color='var(--accent)';$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.color='var(--text-secondary)';$event.currentTarget.style.background=''" title="Edit">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
            </button>
            <button @click="deleteItem(cert.id)" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.color='#f43f5e';$event.currentTarget.style.background='rgba(244,63,94,0.1)'" @mouseleave="$event.currentTarget.style.color='var(--text-secondary)';$event.currentTarget.style.background=''" title="Delete">
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
          <h3 class="text-xl font-bold" style="color: var(--text-primary);">{{ form.id ? 'Edit' : 'New' }} Certification</h3>
          <p class="text-sm mt-0.5" style="color: var(--text-secondary);">{{ form.id ? 'Update certification details' : 'Add a new professional credential' }}</p>
        </div>
        <button @click="showModal = false" class="p-2 rounded-lg transition" style="color: var(--text-secondary);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
        </button>
      </div>

      <form @submit.prevent="saveItem" class="p-6 space-y-5">
        <!-- Name -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Certification Name <span class="text-red-400">*</span></label>
          <input v-model="form.name" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. AWS Solutions Architect" required>
        </div>

        <!-- Organization -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Issuing Organization <span class="text-red-400">*</span></label>
          <input v-model="form.issuing_organization" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. Amazon Web Services" required>
        </div>

        <!-- Dates -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Issue Date <span class="text-red-400">*</span></label>
            <input type="date" v-model="form.issue_date" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" required>
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Expiry Date <span class="text-xs font-normal" style="color: var(--text-secondary);">(optional)</span></label>
            <input type="date" v-model="form.expiry_date" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
            <p class="text-xs mt-1" style="color: var(--text-secondary);">Leave empty if the certification doesn't expire</p>
          </div>
        </div>

        <!-- Credential ID & URL -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Credential ID</label>
            <input v-model="form.credential_id" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition font-mono text-sm" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="e.g. ABC-123-XYZ">
          </div>
          <div>
            <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Credential URL</label>
            <input v-model="form.credential_url" type="url" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition text-sm" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="https://verify.example.com/...">
          </div>
        </div>

        <!-- Description -->
        <div>
          <label class="block text-sm font-semibold mb-1.5" style="color: var(--text-primary);">Description</label>
          <textarea v-model="form.description" rows="3" class="w-full px-4 py-2.5 rounded-xl focus:ring-2 focus:outline-none transition resize-none" style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);" placeholder="Brief description of what this certification covers..."></textarea>
        </div>

        <!-- Active toggle -->
        <label class="flex items-center gap-3 cursor-pointer p-3 rounded-xl transition" style="border: 1px solid var(--border-color);" @mouseenter="$event.currentTarget.style.background='var(--bg-tertiary)'" @mouseleave="$event.currentTarget.style.background=''">
          <input type="checkbox" v-model="form.is_active" class="w-4 h-4 rounded" style="accent-color: var(--accent);">
          <div>
            <span class="text-sm font-semibold" style="color: var(--text-primary);">Active</span>
            <p class="text-xs mt-0.5" style="color: var(--text-secondary);">Show this certification on your public portfolio</p>
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

const props = defineProps({ certifications: Array });
const showModal = ref(false);

const form = useForm({
  id: null,
  name: '',
  issuing_organization: '',
  issue_date: '',
  expiry_date: '',
  credential_id: '',
  credential_url: '',
  description: '',
  is_active: true,
});

const openModal = (cert = null) => {
  if (cert) {
    Object.keys(form.data()).forEach(k => {
      if (k !== 'id') form[k] = cert[k] ?? '';
    });
    form.id = cert.id;
    form.issue_date = cert.issue_date?.substring(0, 10) || '';
    form.expiry_date = cert.expiry_date?.substring(0, 10) || '';
    form.is_active = cert.is_active ?? true;
  } else {
    form.reset();
    form.id = null;
  }
  showModal.value = true;
};

const saveItem = () => {
  const opts = { onSuccess: () => { showModal.value = false; } };
  form.id
    ? form.put(route('admin.certifications.update', form.id), opts)
    : form.post(route('admin.certifications.store'), opts);
};

const deleteItem = (id) => {
  if (confirm('Delete this certification?')) {
    router.delete(route('admin.certifications.destroy', id));
  }
};
</script>
