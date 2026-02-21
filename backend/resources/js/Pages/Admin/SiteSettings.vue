<template>
  <AdminLayout title="Site Settings" subtitle="Configure your portfolio's identity, branding, and integrations">
    <template #hero-icon>
      <span class="text-2xl select-none">⚙️</span>
    </template>

    <!-- Success Toast -->
    <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="translate-y-0 opacity-100" leave-to-class="-translate-y-2 opacity-0">
      <div v-if="showSaved" class="fixed top-6 right-6 z-50 flex items-center gap-2.5 px-5 py-3 rounded-2xl shadow-2xl"
           style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff;">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        <span class="text-sm font-bold">Settings saved successfully</span>
      </div>
    </Transition>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

      <!-- ═══════ LEFT COLUMN — Settings Forms ═══════ -->
      <div class="xl:col-span-2 space-y-6">

        <!-- ── Profile Image Card ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden group/card transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(139,92,246,0.12);">
              <svg class="w-4 h-4" style="color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
            <div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Developer Profile Photo</h2>
              <p class="text-[11px]" style="color: var(--text-secondary);">Your personal headshot — displayed on the Home hero and About page</p>
            </div>
          </div>

          <div class="p-6">
            <div class="flex flex-col sm:flex-row items-center gap-6">
              <!-- Preview Circle -->
              <div class="relative shrink-0 group/avatar">
                <div class="w-32 h-32 rounded-full overflow-hidden transition-all duration-300"
                     style="border: 3px solid var(--border-color); box-shadow: 0 0 0 4px var(--bg-secondary), 0 8px 32px rgba(0,0,0,0.3);"
                     @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
                     @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
                  <img v-if="currentProfileImage"
                       :src="currentProfileImage"
                       alt="Profile"
                       class="w-full h-full object-cover transition-transform duration-300 group-hover/avatar:scale-105" />
                  <div v-else class="w-full h-full flex items-center justify-center" style="background: var(--bg-tertiary);">
                    <svg class="w-12 h-12 opacity-40" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                  </div>
                </div>
                <!-- Status badge -->
                <div class="absolute -bottom-0.5 -right-0.5 w-7 h-7 rounded-full flex items-center justify-center border-[3px] transition-colors"
                     :style="{ background: currentProfileImage ? 'var(--accent)' : 'var(--bg-tertiary)', borderColor: 'var(--bg-secondary)' }">
                  <svg v-if="currentProfileImage" class="w-3.5 h-3.5 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                  </svg>
                  <svg v-else class="w-3.5 h-3.5" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                  </svg>
                </div>
              </div>

              <!-- Upload controls -->
              <div class="flex-1 text-center sm:text-left space-y-3">
                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                  <label class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-xs cursor-pointer transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0"
                         style="background: var(--accent); color: #000;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                    </svg>
                    {{ uploading ? 'Uploading...' : 'Upload Image' }}
                    <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" class="hidden" @change="handleImageUpload" :disabled="uploading" />
                  </label>

                  <button v-if="currentProfileImage" type="button" @click="removeImage" :disabled="uploading"
                          class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl font-semibold text-xs transition-all border hover:-translate-y-0.5 active:translate-y-0"
                          style="color: #ef4444; border-color: rgba(239,68,68,0.25); background: rgba(239,68,68,0.08);"
                          @mouseenter="$event.currentTarget.style.background = 'rgba(239,68,68,0.15)'"
                          @mouseleave="$event.currentTarget.style.background = 'rgba(239,68,68,0.08)'">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Remove
                  </button>
                </div>

                <div class="flex items-center gap-1.5 text-[11px]" style="color: var(--text-secondary);">
                  <svg class="w-3.5 h-3.5 flex-shrink-0 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                  JPG, PNG, WebP · Max 5 MB · Stored in database (survives hard refresh)
                </div>

                <p v-if="uploadError" class="text-xs font-semibold flex items-center gap-1.5 text-red-400">
                  <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.27 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                  {{ uploadError }}
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- ── Branding & Identity Card ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,0.12);">
              <svg class="w-4 h-4" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
              </svg>
            </div>
            <div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Branding & Identity</h2>
              <p class="text-[11px]" style="color: var(--text-secondary);">Name, tagline, and branding used across all pages</p>
            </div>
          </div>

          <form @submit.prevent="saveSettings" class="p-6">
            <div class="space-y-5">
              <div v-for="setting in brandingSettings" :key="setting.key" class="group/field">
                <label class="flex items-center justify-between mb-1.5">
                  <span class="text-xs font-bold uppercase tracking-wider" style="color: var(--text-secondary);">{{ setting.label }}</span>
                  <span v-if="setting.key === 'site_icon_letter'" class="text-[10px] font-medium px-2 py-0.5 rounded-full"
                        :style="{ background: (setting.value?.length || 0) > 2 ? 'rgba(239,68,68,0.15)' : 'var(--bg-tertiary)', color: (setting.value?.length || 0) > 2 ? '#ef4444' : 'var(--text-secondary)' }">
                    {{ setting.value?.length || 0 }}/2
                  </span>
                </label>
                <div class="relative">
                  <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center opacity-40">
                    <svg v-if="setting.key === 'site_name'" class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <svg v-else-if="setting.key === 'site_tagline'" class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                    <svg v-else-if="setting.key === 'site_icon_letter'" class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <svg v-else class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  </div>
                  <input v-model="setting.value" type="text"
                         class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:outline-none transition-all duration-200"
                         style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                         :placeholder="getPlaceholder(setting.key)"
                         :maxlength="setting.key === 'site_icon_letter' ? 2 : 255"
                         @focus="$event.target.style.borderColor = 'var(--accent)'"
                         @blur="$event.target.style.borderColor = 'var(--border-color)'" />
                </div>
                <p class="text-[11px] mt-1.5 leading-relaxed" style="color: var(--text-secondary);">{{ getHelpText(setting.key) }}</p>
              </div>
            </div>

            <!-- Save button -->
            <div class="flex items-center justify-between pt-6 mt-6" style="border-top: 1px solid var(--border-color);">
              <p class="text-[11px]" style="color: var(--text-secondary);">Changes apply instantly across all pages</p>
              <button type="submit" :disabled="saving"
                      class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-xs transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:hover:translate-y-0"
                      style="background: var(--accent); color: #000;">
                <svg v-if="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                </svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ saving ? 'Saving...' : 'Save Settings' }}
              </button>
            </div>
          </form>
        </div>

        <!-- ── Integrations Card (Google Analytics) ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.12);">
              <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
              </svg>
            </div>
            <div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Integrations</h2>
              <p class="text-[11px]" style="color: var(--text-secondary);">Connect third-party analytics and tracking services</p>
            </div>
          </div>

          <form @submit.prevent="saveSettings" class="p-6">
            <div v-for="setting in integrationSettings" :key="setting.key" class="group/field">
              <label class="text-xs font-bold uppercase tracking-wider mb-1.5 block" style="color: var(--text-secondary);">{{ setting.label }}</label>
              <div class="relative">
                <div class="absolute left-3 top-1/2 -translate-y-1/2 w-5 h-5 flex items-center justify-center opacity-40">
                  <svg class="w-4 h-4" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                  </svg>
                </div>
                <input v-model="setting.value" type="text"
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl text-sm focus:ring-2 focus:outline-none transition-all duration-200 font-mono"
                       style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                       :placeholder="getPlaceholder(setting.key)"
                       @focus="$event.target.style.borderColor = 'var(--accent)'"
                       @blur="$event.target.style.borderColor = 'var(--border-color)'" />
                <!-- Status indicator -->
                <div class="absolute right-3 top-1/2 -translate-y-1/2">
                  <span v-if="setting.value && setting.value.startsWith('G-')" class="flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full" style="background: rgba(16,185,129,0.12); color: #10b981;">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    Active
                  </span>
                  <span v-else class="flex items-center gap-1 text-[10px] font-semibold px-2 py-0.5 rounded-full" style="background: var(--bg-tertiary); color: var(--text-secondary);">
                    Not configured
                  </span>
                </div>
              </div>
              <p class="text-[11px] mt-1.5 leading-relaxed" style="color: var(--text-secondary);">{{ getHelpText(setting.key) }}</p>

              <!-- GA Setup Guide -->
              <div class="mt-4 p-4 rounded-xl" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                <h4 class="text-[11px] font-bold uppercase tracking-wider mb-2.5" style="color: var(--text-secondary);">Quick Setup Guide</h4>
                <ol class="space-y-1.5 text-[11px]" style="color: var(--text-secondary);">
                  <li class="flex items-start gap-2">
                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 text-[9px] font-bold mt-px" style="background: var(--accent); color: #000;">1</span>
                    Go to <a href="https://analytics.google.com" target="_blank" rel="noopener" class="font-semibold underline underline-offset-2 transition" style="color: var(--accent);">analytics.google.com</a>
                  </li>
                  <li class="flex items-start gap-2">
                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 text-[9px] font-bold mt-px" style="background: var(--accent); color: #000;">2</span>
                    Admin → Data Streams → Select your stream
                  </li>
                  <li class="flex items-start gap-2">
                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 text-[9px] font-bold mt-px" style="background: var(--accent); color: #000;">3</span>
                    Copy the <strong style="color: var(--text-primary);">Measurement ID</strong> (starts with G-)
                  </li>
                  <li class="flex items-start gap-2">
                    <span class="w-4 h-4 rounded-full flex items-center justify-center flex-shrink-0 text-[9px] font-bold mt-px" style="background: var(--accent); color: #000;">4</span>
                    Paste it above and save settings
                  </li>
                </ol>
              </div>
            </div>

            <!-- Save button -->
            <div class="flex justify-end pt-6 mt-6" style="border-top: 1px solid var(--border-color);">
              <button type="submit" :disabled="saving"
                      class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-bold text-xs transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:translate-y-0 disabled:opacity-50 disabled:hover:translate-y-0"
                      style="background: var(--accent); color: #000;">
                <svg v-if="saving" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                  <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                  <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" />
                </svg>
                <svg v-else class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                {{ saving ? 'Saving...' : 'Save Settings' }}
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- ═══════ RIGHT COLUMN — Live Preview (sticky) ═══════ -->
      <div class="xl:col-span-1">
        <div class="xl:sticky xl:top-24 space-y-6">

          <!-- Live Preview Card -->
          <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
               style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
               @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
               @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(16,185,129,0.12);">
                <svg class="w-4 h-4" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </div>
              <div>
                <h2 class="text-sm font-bold" style="color: var(--text-primary);">Live Preview</h2>
                <p class="text-[10px]" style="color: var(--text-secondary);">Real-time preview of changes</p>
              </div>
            </div>

            <div class="p-5 space-y-4">
              <!-- Simulated navbar -->
              <div>
                <p class="text-[9px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5" style="color: var(--text-secondary);">
                  <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                  Navbar — Website Logo
                </p>
                <div class="rounded-xl p-3 flex items-center gap-3" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                  <div class="w-8 h-8 rounded-lg flex items-center justify-center shadow-md flex-shrink-0" style="background: var(--accent);">
                    <span class="font-black text-xs" style="color: #000;">{{ getSetting('site_icon_letter') || 'J' }}</span>
                  </div>
                  <div class="min-w-0">
                    <span class="text-sm font-bold block truncate" style="color: var(--text-primary);">{{ getSetting('site_name') || 'jaykod.io' }}</span>
                    <span class="text-[10px] block truncate" style="color: var(--text-secondary);">{{ getSetting('site_tagline') || "Jay's digital playground" }}</span>
                  </div>
                </div>
              </div>

              <!-- Simulated hero section -->
              <div>
                <p class="text-[9px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5" style="color: var(--text-secondary);">
                  <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  Hero — Developer Photo
                </p>
                <div class="rounded-xl p-4 text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                  <div class="w-16 h-16 rounded-full mx-auto mb-3 overflow-hidden" style="border: 2px solid var(--border-color);">
                    <img v-if="currentProfileImage" :src="currentProfileImage" alt="" class="w-full h-full object-cover" />
                    <div v-else class="w-full h-full flex items-center justify-center" style="background: var(--bg-secondary);">
                      <span class="text-lg font-black" style="color: var(--accent);">{{ getSetting('site_icon_letter') || 'J' }}</span>
                    </div>
                  </div>
                  <p class="text-xs font-bold" style="color: var(--text-primary);">{{ getSetting('site_name') || 'jaykod.io' }}</p>
                  <p class="text-[10px] mt-0.5" style="color: var(--text-secondary);">{{ getSetting('site_tagline') || "Jay's digital playground" }}</p>
                </div>
              </div>

              <!-- Simulated footer -->
              <div>
                <p class="text-[9px] font-bold uppercase tracking-widest mb-1.5 flex items-center gap-1.5" style="color: var(--text-secondary);">
                  <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 13l-7 7-7-7m14-8l-7 7-7-7"/></svg>
                  Footer
                </p>
                <div class="rounded-xl px-4 py-3" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                  <div class="flex items-center justify-between">
                    <p class="text-[10px]" style="color: var(--text-secondary);">
                      &copy; {{ new Date().getFullYear() }} {{ getSetting('site_name') || 'jaykod.io' }}
                    </p>
                    <p class="text-[10px]" style="color: var(--text-secondary);">
                      {{ getSetting('site_footer_text') || 'Crafted with love' }}
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Quick Links Card -->
          <div class="rounded-2xl shadow-sm overflow-hidden"
               style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(236,72,153,0.12);">
                <svg class="w-4 h-4" style="color: #ec4899;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                </svg>
              </div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Related</h2>
            </div>
            <div class="p-2.5 space-y-0.5">
              <Link :href="route('admin.theme.index')"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all group"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
                <span class="text-sm">🎨</span>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-semibold block" style="color: var(--text-primary);">Theme & Colors</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Customize the color scheme</span>
                </div>
                <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-opacity" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </Link>
              <Link :href="route('admin.contact-info.index')"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all group"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
                <span class="text-sm">📬</span>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-semibold block" style="color: var(--text-primary);">Social Links</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Manage contact and social media</span>
                </div>
                <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-opacity" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </Link>
              <Link :href="route('admin.profile-sections.index')"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all group"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
                <span class="text-sm">👤</span>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-semibold block" style="color: var(--text-primary);">Profile Sections</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Bio, mission, and vision</span>
                </div>
                <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-opacity" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </Link>
              <Link :href="route('admin.database.index')"
                    class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-all group"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
                <span class="text-sm">🗄️</span>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-semibold block" style="color: var(--text-primary);">Database</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Backup, restore, and manage data</span>
                </div>
                <svg class="w-3.5 h-3.5 opacity-0 group-hover:opacity-100 transition-opacity" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </Link>
            </div>
          </div>

        </div>
      </div>

    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { reactive, ref, computed } from 'vue';
import axios from 'axios';

const props = defineProps({
  settings: Array,
});

const saving = ref(false);
const uploading = ref(false);
const uploadError = ref('');
const showSaved = ref(false);
let savedTimeout = null;

const form = reactive({
  settings: props.settings.map(s => ({ ...s })),
});

// Profile image is handled separately from text settings
const currentProfileImage = computed(() => {
  const s = form.settings.find(s => s.key === 'site_profile_image');
  return s?.value || '';
});

// Branding settings (exclude profile_image, theme_, and integrations)
const brandingSettings = computed(() =>
  form.settings.filter(s =>
    s.key !== 'site_profile_image' &&
    !s.key.startsWith('theme_') &&
    s.key !== 'google_analytics_id'
  )
);

// Integration settings (GA, etc.)
const integrationSettings = computed(() =>
  form.settings.filter(s => s.key === 'google_analytics_id')
);

const getSetting = (key) => {
  const s = form.settings.find(s => s.key === key);
  return s?.value || '';
};

const getPlaceholder = (key) => {
  const placeholders = {
    site_name: 'e.g. jaykod.io',
    site_tagline: "e.g. Jay's digital playground",
    site_icon_letter: 'e.g. JK (website logo initials)',
    site_footer_text: 'e.g. Crafted with passion',
    google_analytics_id: 'G-XXXXXXXXXX',
  };
  return placeholders[key] || '';
};

const getHelpText = (key) => {
  const help = {
    site_name: 'Appears in the navigation bar, footer, browser tab, and admin sidebar.',
    site_tagline: 'Shown below the site name in the footer and login page.',
    site_icon_letter: 'The initials shown in the website logo (navbar & favicon). Not your profile photo — this is the site icon.',
    site_footer_text: 'Custom text shown in the footer copyright area.',
    google_analytics_id: 'Your GA4 Measurement ID (starts with G-). Found in Google Analytics → Admin → Data Streams.',
  };
  return help[key] || '';
};

const triggerSavedToast = () => {
  showSaved.value = true;
  clearTimeout(savedTimeout);
  savedTimeout = setTimeout(() => { showSaved.value = false; }, 3000);
};

const handleImageUpload = async (event) => {
  const file = event.target.files?.[0];
  if (!file) return;

  uploadError.value = '';

  const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
  if (!allowedTypes.includes(file.type)) {
    uploadError.value = 'Please upload a JPG, PNG, or WebP image.';
    event.target.value = '';
    return;
  }
  if (file.size > 5 * 1024 * 1024) {
    uploadError.value = 'Image must be under 5MB.';
    event.target.value = '';
    return;
  }

  uploading.value = true;

  try {
    // Upload the file directly — backend converts to base64 and stores in DB
    const formData = new FormData();
    formData.append('image', file);

    const { data } = await axios.post(route('admin.settings.profile-image.update'), formData);

    // Update local state with the base64 data URI returned from server
    const setting = form.settings.find(s => s.key === 'site_profile_image');
    if (setting) setting.value = data.image;

    triggerSavedToast();
  } catch (err) {
    uploadError.value = err.response?.data?.message || 'Upload failed. Please try again.';
  } finally {
    uploading.value = false;
  }

  event.target.value = '';
};

const removeImage = async () => {
  uploading.value = true;
  uploadError.value = '';

  try {
    await axios.delete(route('admin.settings.profile-image.destroy'));

    const setting = form.settings.find(s => s.key === 'site_profile_image');
    if (setting) setting.value = '';

    triggerSavedToast();
  } catch (err) {
    uploadError.value = 'Failed to remove image.';
  } finally {
    uploading.value = false;
  }
};

const saveSettings = () => {
  saving.value = true;
  router.put(route('admin.settings.update'), {
    settings: form.settings
      .filter(s => s.key !== 'site_profile_image')
      .map(s => ({ key: s.key, value: s.value })),
  }, {
    preserveScroll: true,
    onSuccess: () => triggerSavedToast(),
    onFinish: () => { saving.value = false; },
  });
};
</script>
