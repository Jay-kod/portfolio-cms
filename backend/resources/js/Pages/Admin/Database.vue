<template>
  <AdminLayout title="Database Management" subtitle="Backup, restore, and manage your portfolio database">
    <template #hero-icon>
      <span class="text-2xl select-none">🗄️</span>
    </template>

    <!-- Success/Error Toast -->
    <Transition enter-active-class="transition duration-300 ease-out" enter-from-class="translate-y-2 opacity-0" enter-to-class="translate-y-0 opacity-100"
                leave-active-class="transition duration-200 ease-in" leave-from-class="translate-y-0 opacity-100" leave-to-class="-translate-y-2 opacity-0">
      <div v-if="toast.show" class="fixed top-6 right-6 z-50 flex items-center gap-2.5 px-5 py-3 rounded-2xl shadow-2xl max-w-sm"
           :style="{ background: toast.type === 'success' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)', color: '#fff' }">
        <svg v-if="toast.type === 'success'" class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        <svg v-else class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
        <span class="text-sm font-bold">{{ toast.message }}</span>
      </div>
    </Transition>

    <!-- Confirm Modal -->
    <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="confirmModal.show" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7);" @click.self="confirmModal.show = false">
        <div class="rounded-2xl p-6 max-w-md w-full shadow-2xl" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
          <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" :style="{ background: confirmModal.danger ? 'rgba(239,68,68,0.12)' : 'rgba(59,130,246,0.12)' }">
              <svg class="w-5 h-5" :style="{ color: confirmModal.danger ? '#ef4444' : '#3b82f6' }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
              </svg>
            </div>
            <div>
              <h3 class="text-sm font-bold" style="color: var(--text-primary);">{{ confirmModal.title }}</h3>
              <p class="text-xs mt-0.5" style="color: var(--text-secondary);">{{ confirmModal.message }}</p>
            </div>
          </div>
          <div class="flex justify-end gap-2">
            <button @click="confirmModal.show = false"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all"
                    style="color: var(--text-secondary); background: var(--bg-tertiary);">
              Cancel
            </button>
            <button @click="confirmModal.action(); confirmModal.show = false"
                    class="px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md"
                    :style="{ background: confirmModal.danger ? '#ef4444' : 'var(--accent)', color: confirmModal.danger ? '#fff' : '#000' }">
              {{ confirmModal.confirmText }}
            </button>
          </div>
        </div>
      </div>
    </Transition>

    <!-- Table Detail Modal -->
    <Transition enter-active-class="transition duration-200 ease-out" enter-from-class="opacity-0" enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in" leave-from-class="opacity-100" leave-to-class="opacity-0">
      <div v-if="tableModal.show" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="background: rgba(0,0,0,0.7);" @click.self="tableModal.show = false">
        <div class="rounded-2xl max-w-4xl w-full max-h-[85vh] flex flex-col shadow-2xl" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
          <!-- Header -->
          <div class="flex items-center justify-between px-6 py-4 flex-shrink-0" style="border-bottom: 1px solid var(--border-color);">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(139,92,246,0.12);">
                <svg class="w-4 h-4" style="color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/></svg>
              </div>
              <div>
                <h3 class="text-sm font-bold" style="color: var(--text-primary);">{{ tableModal.table }}</h3>
                <p class="text-[11px]" style="color: var(--text-secondary);">{{ tableModal.rowCount }} rows · {{ tableModal.columns?.length || 0 }} columns</p>
              </div>
            </div>
            <button @click="tableModal.show = false" class="p-2 rounded-lg transition-colors" style="color: var(--text-secondary);"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
          </div>

          <!-- Columns -->
          <div class="px-6 py-3 flex-shrink-0" style="border-bottom: 1px solid var(--border-color);">
            <p class="text-[10px] font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Columns</p>
            <div class="flex flex-wrap gap-1.5">
              <span v-for="col in tableModal.columns" :key="col.name"
                    class="px-2 py-1 rounded-md text-[10px] font-mono"
                    style="background: var(--bg-tertiary); color: var(--text-secondary); border: 1px solid var(--border-color);">
                {{ col.name }} <span class="opacity-50">{{ col.type_name }}</span>
              </span>
            </div>
          </div>

          <!-- Sample Data -->
          <div class="flex-1 overflow-auto px-6 py-4">
            <p class="text-[10px] font-bold uppercase tracking-wider mb-2" style="color: var(--text-secondary);">Sample Data (first 10 rows)</p>
            <div v-if="tableModal.sampleRows?.length" class="overflow-x-auto rounded-xl" style="border: 1px solid var(--border-color);">
              <table class="w-full text-xs">
                <thead>
                  <tr style="background: var(--bg-tertiary);">
                    <th v-for="col in tableModal.columns" :key="col.name"
                        class="px-3 py-2 text-left font-bold whitespace-nowrap" style="color: var(--text-secondary); border-bottom: 1px solid var(--border-color);">
                      {{ col.name }}
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(row, i) in tableModal.sampleRows" :key="i"
                      style="border-bottom: 1px solid var(--border-color);"
                      @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                      @mouseleave="$event.currentTarget.style.background = 'transparent'">
                    <td v-for="col in tableModal.columns" :key="col.name"
                        class="px-3 py-2 whitespace-nowrap max-w-[200px] truncate" style="color: var(--text-primary);">
                      {{ formatCellValue(row[col.name]) }}
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
            <div v-else class="text-center py-8">
              <p class="text-xs" style="color: var(--text-secondary);">Table is empty</p>
            </div>
          </div>
        </div>
      </div>
    </Transition>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
      <!-- ═══════ LEFT COLUMN ═══════ -->
      <div class="xl:col-span-2 space-y-6">

        <!-- ── Database Info Card ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(59,130,246,0.12);">
              <svg class="w-4 h-4" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
              </svg>
            </div>
            <div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Database Overview</h2>
              <p class="text-[11px]" style="color: var(--text-secondary);">Connection status and statistics</p>
            </div>
          </div>

          <div class="p-6">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
              <div class="rounded-xl p-3.5 text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                <p class="text-xl font-black" style="color: var(--accent);">{{ dbInfo.table_count }}</p>
                <p class="text-[10px] font-semibold uppercase tracking-wider mt-1" style="color: var(--text-secondary);">Tables</p>
              </div>
              <div class="rounded-xl p-3.5 text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                <p class="text-xl font-black" style="color: #3b82f6;">{{ dbInfo.size_mb }} MB</p>
                <p class="text-[10px] font-semibold uppercase tracking-wider mt-1" style="color: var(--text-secondary);">Size</p>
              </div>
              <div class="rounded-xl p-3.5 text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                <p class="text-xl font-black" style="color: #a855f7;">{{ totalRows }}</p>
                <p class="text-[10px] font-semibold uppercase tracking-wider mt-1" style="color: var(--text-secondary);">Total Rows</p>
              </div>
              <div class="rounded-xl p-3.5 text-center" style="background: var(--bg-tertiary); border: 1px solid var(--border-color);">
                <p class="text-xl font-black" style="color: #f59e0b;">{{ backups.length }}</p>
                <p class="text-[10px] font-semibold uppercase tracking-wider mt-1" style="color: var(--text-secondary);">Backups</p>
              </div>
            </div>

            <div class="mt-4 grid grid-cols-2 gap-3">
              <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background: var(--bg-tertiary);">
                <span class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--text-secondary);">Database</span>
                <span class="text-xs font-mono font-semibold ml-auto" style="color: var(--text-primary);">{{ dbInfo.name }}</span>
              </div>
              <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background: var(--bg-tertiary);">
                <span class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--text-secondary);">Version</span>
                <span class="text-xs font-mono font-semibold ml-auto" style="color: var(--text-primary);">{{ dbInfo.version }}</span>
              </div>
              <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background: var(--bg-tertiary);">
                <span class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--text-secondary);">Host</span>
                <span class="text-xs font-mono font-semibold ml-auto" style="color: var(--text-primary);">{{ dbInfo.host }}:{{ dbInfo.port }}</span>
              </div>
              <div class="flex items-center gap-2 px-3 py-2 rounded-lg" style="background: var(--bg-tertiary);">
                <span class="text-[10px] font-bold uppercase tracking-wider" style="color: var(--text-secondary);">Charset</span>
                <span class="text-xs font-mono font-semibold ml-auto" style="color: var(--text-primary);">{{ dbInfo.charset }}</span>
              </div>
            </div>
          </div>
        </div>

        <!-- ── Tables Card ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(139,92,246,0.12);">
                <svg class="w-4 h-4" style="color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-sm font-bold" style="color: var(--text-primary);">Tables</h2>
                <p class="text-[11px]" style="color: var(--text-secondary);">{{ tables.length }} tables in the database</p>
              </div>
            </div>
            <div class="relative">
              <svg class="w-3.5 h-3.5 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              <input v-model="tableSearch" type="text" placeholder="Filter tables..."
                     class="pl-9 pr-3 py-1.5 rounded-lg text-xs w-48 outline-none transition-all"
                     style="background: var(--bg-tertiary); color: var(--text-primary); border: 1px solid var(--border-color);"
                     @focus="$event.target.style.borderColor = 'var(--accent)'"
                     @blur="$event.target.style.borderColor = 'var(--border-color)'" />
            </div>
          </div>

          <div class="overflow-x-auto">
            <table class="w-full text-xs">
              <thead>
                <tr style="background: var(--bg-tertiary);">
                  <th class="px-6 py-3 text-left font-bold uppercase tracking-wider text-[10px]" style="color: var(--text-secondary);">Table</th>
                  <th class="px-4 py-3 text-right font-bold uppercase tracking-wider text-[10px]" style="color: var(--text-secondary);">Rows</th>
                  <th class="px-4 py-3 text-right font-bold uppercase tracking-wider text-[10px]" style="color: var(--text-secondary);">Size</th>
                  <th class="px-4 py-3 text-right font-bold uppercase tracking-wider text-[10px]" style="color: var(--text-secondary);">Engine</th>
                  <th class="px-6 py-3 text-right font-bold uppercase tracking-wider text-[10px]" style="color: var(--text-secondary);">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="table in filteredTables" :key="table.name"
                    class="group transition-colors"
                    style="border-bottom: 1px solid var(--border-color);"
                    @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                    @mouseleave="$event.currentTarget.style.background = 'transparent'">
                  <td class="px-6 py-3">
                    <span class="font-mono font-semibold" style="color: var(--text-primary);">{{ table.name }}</span>
                  </td>
                  <td class="px-4 py-3 text-right font-mono" style="color: var(--text-secondary);">{{ table.rows ?? 0 }}</td>
                  <td class="px-4 py-3 text-right font-mono" style="color: var(--text-secondary);">{{ table.size_kb }} KB</td>
                  <td class="px-4 py-3 text-right">
                    <span class="px-2 py-0.5 rounded text-[9px] font-bold uppercase" style="background: rgba(59,130,246,0.1); color: #3b82f6;">{{ table.engine }}</span>
                  </td>
                  <td class="px-6 py-3 text-right">
                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                      <button @click="viewTable(table.name)" class="p-1.5 rounded-lg transition-colors" title="View details"
                              style="color: var(--accent);"
                              @mouseenter="$event.currentTarget.style.background = 'rgba(0,255,136,0.1)'"
                              @mouseleave="$event.currentTarget.style.background = 'transparent'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                      </button>
                      <button v-if="!isProtectedTable(table.name)" @click="confirmTruncate(table.name)"
                              class="p-1.5 rounded-lg transition-colors" title="Truncate table"
                              style="color: #ef4444;"
                              @mouseenter="$event.currentTarget.style.background = 'rgba(239,68,68,0.1)'"
                              @mouseleave="$event.currentTarget.style.background = 'transparent'">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                      </button>
                      <span v-else class="p-1.5 opacity-30" title="Protected table">
                        <svg class="w-3.5 h-3.5" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                      </span>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- ── Backups Card ── -->
        <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
             style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
             @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
             @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
          <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.12);">
                <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                </svg>
              </div>
              <div>
                <h2 class="text-sm font-bold" style="color: var(--text-primary);">Backups</h2>
                <p class="text-[11px]" style="color: var(--text-secondary);">{{ backups.length }} backup{{ backups.length !== 1 ? 's' : '' }} available</p>
              </div>
            </div>
            <button @click="createBackup" :disabled="loading.backup"
                    class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 active:translate-y-0"
                    style="background: var(--accent); color: #000;">
              <svg v-if="!loading.backup" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
              <svg v-else class="w-3.5 h-3.5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
              {{ loading.backup ? 'Creating...' : 'Create Backup' }}
            </button>
          </div>

          <div v-if="backups.length === 0" class="p-12 text-center">
            <svg class="w-12 h-12 mx-auto mb-3 opacity-20" style="color: var(--text-secondary);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
            </svg>
            <p class="text-xs font-semibold" style="color: var(--text-secondary);">No backups yet</p>
            <p class="text-[11px] mt-1" style="color: var(--text-secondary);">Click "Create Backup" to generate your first database backup</p>
          </div>

          <div v-else class="divide-y" style="border-color: var(--border-color);">
            <div v-for="backup in backups" :key="backup.filename"
                 class="flex items-center gap-4 px-6 py-4 group transition-colors"
                 @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                 @mouseleave="$event.currentTarget.style.background = 'transparent'">
              <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.08); border: 1px solid rgba(245,158,11,0.15);">
                <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
              </div>
              <div class="flex-1 min-w-0">
                <p class="text-xs font-bold font-mono truncate" style="color: var(--text-primary);">{{ backup.filename }}</p>
                <p class="text-[10px] mt-0.5" style="color: var(--text-secondary);">{{ backup.size_kb }} KB · {{ backup.created_at }}</p>
              </div>
              <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                <a :href="route('admin.database.backup.download', backup.filename)"
                   class="p-2 rounded-lg transition-colors" title="Download"
                   style="color: #3b82f6;"
                   @mouseenter="$event.currentTarget.style.background = 'rgba(59,130,246,0.1)'"
                   @mouseleave="$event.currentTarget.style.background = 'transparent'">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                </a>
                <button @click="confirmRestore(backup.filename)" class="p-2 rounded-lg transition-colors" title="Restore this backup"
                        style="color: #f59e0b;"
                        @mouseenter="$event.currentTarget.style.background = 'rgba(245,158,11,0.1)'"
                        @mouseleave="$event.currentTarget.style.background = 'transparent'">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </button>
                <button @click="confirmDeleteBackup(backup.filename)" class="p-2 rounded-lg transition-colors" title="Delete backup"
                        style="color: #ef4444;"
                        @mouseenter="$event.currentTarget.style.background = 'rgba(239,68,68,0.1)'"
                        @mouseleave="$event.currentTarget.style.background = 'transparent'">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- ═══════ RIGHT COLUMN — Actions & Quick Tools ═══════ -->
      <div class="space-y-6">
        <div class="xl:sticky xl:top-6 space-y-6">

          <!-- ── Quick Actions Card ── -->
          <div class="rounded-2xl shadow-sm overflow-hidden transition-all duration-300"
               style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
               @mouseenter="$event.currentTarget.style.borderColor = 'var(--accent)'"
               @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(0,255,136,0.12);">
                <svg class="w-4 h-4" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
              </div>
              <div>
                <h2 class="text-sm font-bold" style="color: var(--text-primary);">Quick Actions</h2>
                <p class="text-[11px]" style="color: var(--text-secondary);">Common database operations</p>
              </div>
            </div>

            <div class="p-4 space-y-2">
              <!-- Create Backup -->
              <button @click="createBackup" :disabled="loading.backup"
                      class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group text-left"
                      style="border: 1px solid var(--border-color);"
                      @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'; $event.currentTarget.style.borderColor = 'var(--accent)'"
                      @mouseleave="$event.currentTarget.style.background = 'transparent'; $event.currentTarget.style.borderColor = 'var(--border-color)'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(245,158,11,0.12);">
                  <svg v-if="!loading.backup" class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                  </svg>
                  <svg v-else class="w-4 h-4 animate-spin" style="color: #f59e0b;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-bold block" style="color: var(--text-primary);">Create Backup</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Full SQL dump of all tables</span>
                </div>
              </button>

              <!-- Run Migrations -->
              <button @click="confirmAction('Run Migrations', 'This will apply any pending database migrations.', runMigrations, false)"
                      :disabled="loading.migrate"
                      class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group text-left"
                      style="border: 1px solid var(--border-color);"
                      @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'; $event.currentTarget.style.borderColor = 'var(--accent)'"
                      @mouseleave="$event.currentTarget.style.background = 'transparent'; $event.currentTarget.style.borderColor = 'var(--border-color)'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(59,130,246,0.12);">
                  <svg v-if="!loading.migrate" class="w-4 h-4" style="color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                  </svg>
                  <svg v-else class="w-4 h-4 animate-spin" style="color: #3b82f6;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-bold block" style="color: var(--text-primary);">Run Migrations</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Apply pending schema changes</span>
                </div>
              </button>

              <!-- Run Seeders -->
              <button @click="confirmAction('Run Seeders', 'This will execute all database seeders. Existing data may be affected.', runSeeders, true)"
                      :disabled="loading.seed"
                      class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group text-left"
                      style="border: 1px solid var(--border-color);"
                      @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'; $event.currentTarget.style.borderColor = 'var(--accent)'"
                      @mouseleave="$event.currentTarget.style.background = 'transparent'; $event.currentTarget.style.borderColor = 'var(--border-color)'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(139,92,246,0.12);">
                  <svg v-if="!loading.seed" class="w-4 h-4" style="color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/>
                  </svg>
                  <svg v-else class="w-4 h-4 animate-spin" style="color: #a855f7;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-bold block" style="color: var(--text-primary);">Run Seeders</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Populate tables with default data</span>
                </div>
              </button>

              <!-- Clear Cache -->
              <button @click="clearCache" :disabled="loading.cache"
                      class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all group text-left"
                      style="border: 1px solid var(--border-color);"
                      @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'; $event.currentTarget.style.borderColor = 'var(--accent)'"
                      @mouseleave="$event.currentTarget.style.background = 'transparent'; $event.currentTarget.style.borderColor = 'var(--border-color)'">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background: rgba(16,185,129,0.12);">
                  <svg v-if="!loading.cache" class="w-4 h-4" style="color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                  <svg v-else class="w-4 h-4 animate-spin" style="color: #10b981;" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </div>
                <div class="flex-1 min-w-0">
                  <span class="text-xs font-bold block" style="color: var(--text-primary);">Clear All Caches</span>
                  <span class="text-[10px]" style="color: var(--text-secondary);">Config, routes, views, events</span>
                </div>
              </button>
            </div>
          </div>

          <!-- ── Important Notes Card ── -->
          <div class="rounded-2xl shadow-sm overflow-hidden"
               style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
            <div class="flex items-center gap-3 px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(239,68,68,0.12);">
                <svg class="w-4 h-4" style="color: #ef4444;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.268 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                </svg>
              </div>
              <h2 class="text-sm font-bold" style="color: var(--text-primary);">Important</h2>
            </div>
            <div class="p-5 space-y-3">
              <div class="flex items-start gap-2">
                <span class="text-[10px] mt-0.5" style="color: #ef4444;">●</span>
                <p class="text-[11px] leading-relaxed" style="color: var(--text-secondary);">
                  <strong style="color: var(--text-primary);">Always create a backup</strong> before restoring, running migrations, or truncating tables.
                </p>
              </div>
              <div class="flex items-start gap-2">
                <span class="text-[10px] mt-0.5" style="color: #f59e0b;">●</span>
                <p class="text-[11px] leading-relaxed" style="color: var(--text-secondary);">
                  <strong style="color: var(--text-primary);">Protected tables</strong> (users, migrations, personal_access_tokens) cannot be truncated.
                </p>
              </div>
              <div class="flex items-start gap-2">
                <span class="text-[10px] mt-0.5" style="color: #3b82f6;">●</span>
                <p class="text-[11px] leading-relaxed" style="color: var(--text-secondary);">
                  <strong style="color: var(--text-primary);">Restoring a backup</strong> will overwrite all current data. This cannot be undone.
                </p>
              </div>
              <div class="flex items-start gap-2">
                <span class="text-[10px] mt-0.5" style="color: #10b981;">●</span>
                <p class="text-[11px] leading-relaxed" style="color: var(--text-secondary);">
                  <strong style="color: var(--text-primary);">Backups include everything</strong> — portfolio content, settings, profile photo data, analytics, and user accounts.
                </p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed, reactive } from 'vue';
import axios from 'axios';

const props = defineProps({
  tables: Array,
  dbInfo: Object,
  backups: Array,
});

const tableSearch = ref('');
const backups = ref([...props.backups]);

const loading = reactive({
  backup: false,
  migrate: false,
  seed: false,
  cache: false,
});

const toast = reactive({ show: false, message: '', type: 'success' });
let toastTimeout = null;

const confirmModal = reactive({
  show: false,
  title: '',
  message: '',
  confirmText: 'Confirm',
  danger: false,
  action: () => {},
});

const tableModal = reactive({
  show: false,
  table: '',
  columns: [],
  sampleRows: [],
  rowCount: 0,
});

const totalRows = computed(() => {
  return props.tables.reduce((sum, t) => sum + (t.rows || 0), 0);
});

const filteredTables = computed(() => {
  if (!tableSearch.value) return props.tables;
  const q = tableSearch.value.toLowerCase();
  return props.tables.filter(t => t.name.toLowerCase().includes(q));
});

const isProtectedTable = (name) => ['users', 'migrations', 'personal_access_tokens'].includes(name);

const showToast = (message, type = 'success') => {
  toast.message = message;
  toast.type = type;
  toast.show = true;
  clearTimeout(toastTimeout);
  toastTimeout = setTimeout(() => { toast.show = false; }, 4000);
};

const confirmAction = (title, message, action, danger = false, confirmText = 'Confirm') => {
  confirmModal.title = title;
  confirmModal.message = message;
  confirmModal.action = action;
  confirmModal.danger = danger;
  confirmModal.confirmText = confirmText;
  confirmModal.show = true;
};

const formatCellValue = (value) => {
  if (value === null) return 'NULL';
  if (typeof value === 'string' && value.length > 80) return value.substring(0, 77) + '...';
  return String(value);
};

// ── Actions ──

const createBackup = async () => {
  loading.backup = true;
  try {
    const { data } = await axios.post(route('admin.database.backup.create'));
    if (data.success) {
      backups.value.unshift(data.backup);
      showToast(data.message);
    }
  } catch (err) {
    showToast(err.response?.data?.message || 'Backup failed.', 'error');
  } finally {
    loading.backup = false;
  }
};

const confirmRestore = (filename) => {
  confirmAction(
    'Restore Database',
    `This will OVERWRITE all current data with "${filename}". Create a backup first if needed. This action cannot be undone.`,
    () => restoreBackup(filename),
    true,
    'Restore Now'
  );
};

const restoreBackup = async (filename) => {
  loading.backup = true;
  try {
    const { data } = await axios.post(route('admin.database.backup.restore'), { filename });
    if (data.success) {
      showToast(data.message);
      setTimeout(() => window.location.reload(), 1500);
    }
  } catch (err) {
    showToast(err.response?.data?.message || 'Restore failed.', 'error');
  } finally {
    loading.backup = false;
  }
};

const confirmDeleteBackup = (filename) => {
  confirmAction(
    'Delete Backup',
    `Permanently delete "${filename}"? This cannot be undone.`,
    () => deleteBackup(filename),
    true,
    'Delete'
  );
};

const deleteBackup = async (filename) => {
  try {
    const { data } = await axios.delete(route('admin.database.backup.delete', filename));
    if (data.success) {
      backups.value = backups.value.filter(b => b.filename !== filename);
      showToast(data.message);
    }
  } catch (err) {
    showToast(err.response?.data?.message || 'Delete failed.', 'error');
  }
};

const runMigrations = async () => {
  loading.migrate = true;
  try {
    const { data } = await axios.post(route('admin.database.migrate'));
    showToast(data.success ? data.message : data.message, data.success ? 'success' : 'error');
    if (data.success) setTimeout(() => window.location.reload(), 1500);
  } catch (err) {
    showToast(err.response?.data?.message || 'Migration failed.', 'error');
  } finally {
    loading.migrate = false;
  }
};

const runSeeders = async () => {
  loading.seed = true;
  try {
    const { data } = await axios.post(route('admin.database.seed'));
    showToast(data.success ? data.message : data.message, data.success ? 'success' : 'error');
    if (data.success) setTimeout(() => window.location.reload(), 1500);
  } catch (err) {
    showToast(err.response?.data?.message || 'Seeding failed.', 'error');
  } finally {
    loading.seed = false;
  }
};

const clearCache = async () => {
  loading.cache = true;
  try {
    const { data } = await axios.post(route('admin.database.cache-clear'));
    showToast(data.success ? data.message : data.message, data.success ? 'success' : 'error');
  } catch (err) {
    showToast(err.response?.data?.message || 'Cache clear failed.', 'error');
  } finally {
    loading.cache = false;
  }
};

const viewTable = async (tableName) => {
  try {
    const { data } = await axios.get(route('admin.database.table.details', tableName));
    if (data.success) {
      tableModal.table = data.table;
      tableModal.columns = data.columns;
      tableModal.sampleRows = data.sample_rows;
      tableModal.rowCount = data.row_count;
      tableModal.show = true;
    }
  } catch (err) {
    showToast('Failed to load table details.', 'error');
  }
};

const confirmTruncate = (tableName) => {
  confirmAction(
    'Truncate Table',
    `This will permanently DELETE ALL DATA from "${tableName}". This cannot be undone. Create a backup first.`,
    () => truncateTable(tableName),
    true,
    'Truncate'
  );
};

const truncateTable = async (tableName) => {
  try {
    const { data } = await axios.post(route('admin.database.truncate'), { table: tableName });
    if (data.success) {
      showToast(data.message);
      setTimeout(() => window.location.reload(), 1500);
    }
  } catch (err) {
    showToast(err.response?.data?.message || 'Truncate failed.', 'error');
  }
};
</script>
