<template>
  <AdminLayout title="Dashboard" subtitle="Overview of your portfolio content and activity">
    <template #hero-icon>
      <span class="text-2xl select-none">📊</span>
    </template>

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-8 gap-4 mb-8">
      <div v-for="stat in stats" :key="stat.label"
           class="p-4 rounded-2xl shadow-sm transition-all duration-300 group hover:shadow-md cursor-pointer"
           style="background: var(--bg-secondary); border: 1px solid var(--border-color);"
           @mouseenter="$event.currentTarget.style.borderColor = stat.color"
           @mouseleave="$event.currentTarget.style.borderColor = 'var(--border-color)'"
           @click="stat.href && $inertia.visit(stat.href)">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-transform group-hover:scale-110 text-lg"
               :style="{ background: stat.color + '18' }">
            {{ stat.emoji }}
          </div>
          <div class="min-w-0">
            <div class="text-2xl font-black leading-none" style="color: var(--text-primary);">{{ stat.value }}</div>
            <div class="text-[11px] font-medium mt-1 truncate" style="color: var(--text-secondary);">{{ stat.label }}</div>
          </div>
        </div>
      </div>
    </div>

    <!-- ═══════ ANALYTICS SECTION ═══════ -->
    <!-- Visitor Stats Row -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
      <div v-for="vs in visitorStats" :key="vs.label"
           class="p-4 rounded-2xl transition-all"
           style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center gap-2 mb-2">
          <div class="w-8 h-8 rounded-lg flex items-center justify-center" :style="{ background: vs.color + '18' }">
            <svg class="w-4 h-4" :style="{ color: vs.color }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="vs.icon" />
            </svg>
          </div>
          <span class="text-[11px] font-medium" style="color: var(--text-secondary);">{{ vs.label }}</span>
        </div>
        <div class="text-2xl font-black" style="color: var(--text-primary);">{{ vs.value.toLocaleString() }}</div>
        <div v-if="vs.sub" class="text-[10px] mt-1" style="color: var(--text-secondary);">{{ vs.sub }}</div>
      </div>
    </div>

    <!-- Traffic Chart + Top Pages + Device/Browser -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

      <!-- Traffic Chart (sparkline bar chart) -->
      <div class="lg:col-span-2 rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">📈</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Traffic Overview</h3>
            <span class="text-[10px] font-medium px-2 py-0.5 rounded-full" style="background: var(--bg-tertiary); color: var(--text-secondary);">Last 30 days</span>
          </div>
          <div class="flex items-center gap-3 text-[10px]">
            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm" style="background: var(--accent);"></span> Views</span>
            <span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-sm" style="background: rgba(139,92,246,0.7);"></span> Unique</span>
          </div>
        </div>
        <div class="p-6">
          <!-- Chart -->
          <div class="flex items-end gap-[3px] h-40" v-if="dailyViews.length">
            <div v-for="(day, i) in dailyViews" :key="day.date"
                 class="flex-1 flex flex-col items-center gap-[2px] group relative">
              <!-- Tooltip -->
              <div class="absolute bottom-full mb-2 hidden group-hover:flex flex-col items-center z-10 pointer-events-none">
                <div class="px-2.5 py-1.5 rounded-lg text-[10px] font-medium whitespace-nowrap shadow-lg"
                     style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary);">
                  <div style="color: var(--text-secondary);">{{ day.label }}</div>
                  <div>{{ day.views }} views · {{ day.unique_views }} unique</div>
                </div>
              </div>
              <!-- Bars -->
              <div class="w-full rounded-t-sm transition-all duration-300"
                   :style="{ height: chartBarHeight(day.views) + 'px', background: 'var(--accent)', opacity: 0.85 }"></div>
              <div class="w-full rounded-t-sm transition-all duration-300"
                   :style="{ height: chartBarHeight(day.unique_views) + 'px', background: 'rgba(139,92,246,0.7)' }"></div>
              <!-- Date label (every 5th) -->
              <span v-if="i % 5 === 0" class="text-[8px] mt-1 absolute -bottom-4" style="color: var(--text-secondary);">{{ day.label.split(' ')[1] }}</span>
            </div>
          </div>
          <div v-else class="h-40 flex items-center justify-center">
            <p class="text-sm" style="color: var(--text-secondary);">No traffic data yet. Visit your portfolio to start tracking!</p>
          </div>
        </div>
      </div>

      <!-- Top Pages -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">🏆</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Top Pages</h3>
        </div>
        <div class="p-4">
          <div v-if="topPages.length" class="space-y-2">
            <div v-for="(page, idx) in topPages" :key="page.path"
                 class="flex items-center justify-between px-3 py-2.5 rounded-xl transition"
                 @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                 @mouseleave="$event.currentTarget.style.background = 'transparent'">
              <div class="flex items-center gap-3 min-w-0">
                <span class="text-xs font-bold w-5 text-center" :style="{ color: idx === 0 ? 'var(--accent)' : 'var(--text-secondary)' }">{{ idx + 1 }}</span>
                <div class="min-w-0">
                  <div class="text-sm font-semibold truncate" style="color: var(--text-primary);">{{ page.page_name }}</div>
                  <div class="text-[10px] truncate" style="color: var(--text-secondary);">{{ page.path }}</div>
                </div>
              </div>
              <div class="text-right flex-shrink-0 ml-3">
                <div class="text-sm font-bold" style="color: var(--text-primary);">{{ page.views }}</div>
                <div class="text-[10px]" style="color: var(--text-secondary);">{{ page.unique_views }} unique</div>
              </div>
            </div>
          </div>
          <div v-else class="text-center py-8">
            <p class="text-xs" style="color: var(--text-secondary);">No page data yet</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Device & Browser Breakdown + Referrers -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">

      <!-- Device Breakdown -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">📱</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Devices</h3>
        </div>
        <div class="p-4 space-y-3">
          <div v-for="d in deviceBreakdown" :key="d.device" class="space-y-1">
            <div class="flex items-center justify-between">
              <div class="flex items-center gap-2">
                <span class="text-sm">{{ deviceEmoji(d.device) }}</span>
                <span class="text-xs font-semibold capitalize" style="color: var(--text-primary);">{{ d.device }}</span>
              </div>
              <span class="text-xs font-semibold" style="color: var(--text-secondary);">{{ d.count }} <span class="font-normal">({{ devicePercent(d.count) }}%)</span></span>
            </div>
            <div class="w-full h-1.5 rounded-full overflow-hidden" style="background: var(--bg-tertiary);">
              <div class="h-full rounded-full transition-all duration-500"
                   :style="{ width: devicePercent(d.count) + '%', background: deviceColor(d.device) }"></div>
            </div>
          </div>
          <div v-if="!deviceBreakdown.length" class="text-center py-6">
            <p class="text-xs" style="color: var(--text-secondary);">No device data</p>
          </div>
        </div>
      </div>

      <!-- Browser Breakdown -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">🌐</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Browsers</h3>
        </div>
        <div class="p-4 space-y-3">
          <div v-for="b in browserBreakdown" :key="b.browser" class="space-y-1">
            <div class="flex items-center justify-between">
              <span class="text-xs font-semibold" style="color: var(--text-primary);">{{ b.browser }}</span>
              <span class="text-xs font-semibold" style="color: var(--text-secondary);">{{ b.count }} <span class="font-normal">({{ browserPercent(b.count) }}%)</span></span>
            </div>
            <div class="w-full h-1.5 rounded-full overflow-hidden" style="background: var(--bg-tertiary);">
              <div class="h-full rounded-full transition-all duration-500"
                   :style="{ width: browserPercent(b.count) + '%', background: browserColor(b.browser) }"></div>
            </div>
          </div>
          <div v-if="!browserBreakdown.length" class="text-center py-6">
            <p class="text-xs" style="color: var(--text-secondary);">No browser data</p>
          </div>
        </div>
      </div>

      <!-- Top Referrers -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">🔗</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Referrers</h3>
        </div>
        <div class="p-4">
          <div v-if="topReferrers.length" class="space-y-2">
            <div v-for="ref in topReferrers" :key="ref.referrer"
                 class="flex items-center justify-between px-3 py-2 rounded-xl transition"
                 @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                 @mouseleave="$event.currentTarget.style.background = 'transparent'">
              <span class="text-xs font-medium truncate flex-1 mr-2" style="color: var(--text-primary);">{{ shortenUrl(ref.referrer) }}</span>
              <span class="text-xs font-bold flex-shrink-0" style="color: var(--accent);">{{ ref.count }}</span>
            </div>
          </div>
          <div v-else class="text-center py-6">
            <p class="text-xs" style="color: var(--text-secondary);">No referrer data yet</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

      <!-- Profile Identity Card (editable) -->
      <div class="lg:col-span-2 rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">🪪</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Profile Identity</h3>
          </div>
          <div class="flex items-center gap-2">
            <span v-if="identitySaved" class="text-xs font-medium px-2.5 py-1 rounded-full inline-flex items-center gap-1" style="background: rgba(16,185,129,0.15); color: #10b981;">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Saved
            </span>
            <button @click="saveIdentity" :disabled="identityForm.processing"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all shadow-sm disabled:opacity-50"
                    style="background: var(--accent); color: #000;">
              <span v-if="identityForm.processing" class="inline-flex items-center gap-1.5">
                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Saving...
              </span>
              <span v-else class="inline-flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save Changes
              </span>
            </button>
          </div>
        </div>
        <div class="p-6">
          <div class="flex gap-6 items-start">
            <!-- Profile Image Preview -->
            <div class="flex-shrink-0">
              <div class="w-20 h-20 rounded-2xl overflow-hidden flex items-center justify-center" style="background: var(--bg-tertiary); border: 2px solid var(--border-color);">
                <img v-if="siteProfileImage" :src="siteProfileImage" class="w-full h-full object-cover" alt="Profile">
                <span v-else class="text-2xl font-black" style="color: var(--accent);">{{ siteIconLetter || '?' }}</span>
              </div>
              <Link :href="route('admin.settings.index')" class="text-[10px] font-medium mt-2 block text-center transition" style="color: var(--text-secondary);"
                    @mouseenter="$event.target.style.color = 'var(--accent)'" @mouseleave="$event.target.style.color = 'var(--text-secondary)'">
                Change Photo
              </Link>
            </div>
            <!-- Editable Fields -->
            <div class="flex-1 space-y-4">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                  <label class="block text-xs font-semibold mb-1.5" style="color: var(--text-secondary);">Site Name</label>
                  <input v-model="identityForm.settings[0].value" class="w-full px-3.5 py-2 rounded-xl text-sm focus:ring-2 focus:outline-none transition"
                         style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                         placeholder="Your Portfolio Name">
                </div>
                <div>
                  <label class="block text-xs font-semibold mb-1.5" style="color: var(--text-secondary);">Tagline</label>
                  <input v-model="identityForm.settings[1].value" class="w-full px-3.5 py-2 rounded-xl text-sm focus:ring-2 focus:outline-none transition"
                         style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                         placeholder="Full Stack Developer & Designer">
                </div>
              </div>
              <div>
                <label class="block text-xs font-semibold mb-1.5" style="color: var(--text-secondary);">Mission / Objective</label>
                <textarea v-model="objectiveContent" rows="2" class="w-full px-3.5 py-2 rounded-xl text-sm focus:ring-2 focus:outline-none transition resize-none"
                          style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                          placeholder="Your career mission or objective..."></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Bio Card (editable) -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">✍️</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Bio</h3>
          </div>
          <div class="flex items-center gap-2">
            <span v-if="bioSaved" class="text-xs font-medium px-2.5 py-1 rounded-full inline-flex items-center gap-1" style="background: rgba(16,185,129,0.15); color: #10b981;">
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              Saved
            </span>
            <button @click="saveBio" :disabled="bioForm.processing"
                    class="px-4 py-2 rounded-xl text-xs font-semibold transition-all shadow-sm disabled:opacity-50"
                    style="background: var(--accent); color: #000;">
              <span v-if="bioForm.processing" class="inline-flex items-center gap-1.5">
                <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Saving...
              </span>
              <span v-else class="inline-flex items-center gap-1.5">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                Save
              </span>
            </button>
          </div>
        </div>
        <div class="p-6">
          <textarea v-model="bioForm.content" rows="6" class="w-full px-3.5 py-2.5 rounded-xl text-sm focus:ring-2 focus:outline-none transition resize-none leading-relaxed"
                    style="background: var(--bg-tertiary); border: 1px solid var(--border-color); color: var(--text-primary); --tw-ring-color: var(--accent);"
                    placeholder="Write a short bio about yourself..."></textarea>
          <div class="flex items-center justify-between mt-3">
            <span class="text-[11px]" style="color: var(--text-secondary);">{{ bioForm.content?.length || 0 }} characters</span>
            <Link :href="route('admin.profile-sections.index')" class="text-[11px] font-medium transition inline-flex items-center gap-1" style="color: var(--text-secondary);"
                  @mouseenter="$event.currentTarget.style.color = 'var(--accent)'" @mouseleave="$event.currentTarget.style.color = 'var(--text-secondary)'">
              Manage all sections
              <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </Link>
          </div>
        </div>
      </div>
    </div>

    <!-- Second Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">

      <!-- Portfolio Completeness -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">🎯</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Completeness</h3>
        </div>
        <div class="p-6">
          <!-- Progress Ring -->
          <div class="flex items-center justify-center mb-5">
            <div class="relative w-28 h-28">
              <svg class="w-28 h-28 -rotate-90" viewBox="0 0 120 120">
                <circle cx="60" cy="60" r="52" fill="none" stroke-width="8" style="stroke: var(--bg-tertiary);"/>
                <circle cx="60" cy="60" r="52" fill="none" stroke-width="8" stroke-linecap="round"
                        :stroke-dasharray="2 * Math.PI * 52"
                        :stroke-dashoffset="2 * Math.PI * 52 * (1 - completenessScore / 100)"
                        :style="{ stroke: completenessColor, transition: 'stroke-dashoffset 1s ease' }"/>
              </svg>
              <div class="absolute inset-0 flex flex-col items-center justify-center">
                <span class="text-2xl font-black" style="color: var(--text-primary);">{{ completenessScore }}%</span>
                <span class="text-[10px] font-medium" style="color: var(--text-secondary);">Complete</span>
              </div>
            </div>
          </div>
          <!-- Checklist -->
          <div class="space-y-2">
            <div v-for="item in completenessChecklist" :key="item.label"
                 class="flex items-center gap-2.5 px-3 py-2 rounded-lg transition"
                 :style="{ background: item.done ? 'rgba(16,185,129,0.06)' : 'transparent' }">
              <div class="w-5 h-5 rounded-full flex items-center justify-center flex-shrink-0"
                   :style="{ background: item.done ? '#10b981' : 'var(--bg-tertiary)', border: item.done ? 'none' : '1.5px solid var(--border-color)' }">
                <svg v-if="item.done" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
              </div>
              <span class="text-xs font-medium" :style="{ color: item.done ? 'var(--text-primary)' : 'var(--text-secondary)' }">{{ item.label }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent Resumes -->
      <div class="lg:col-span-2 rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">📄</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Recent Resumes</h3>
          </div>
          <span class="text-xs font-semibold px-2.5 py-1 rounded-full" style="background: var(--accent); color: #000;">{{ recentResumes.length }}</span>
        </div>
        <div v-if="recentResumes.length">
          <div v-for="resume in recentResumes" :key="resume.id"
               class="flex items-center justify-between px-6 py-3.5 transition"
               style="border-bottom: 1px solid var(--border-color);"
               @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
               @mouseleave="$event.currentTarget.style.background = 'transparent'">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center" style="background: rgba(245,158,11,0.12);">
                <svg class="w-4 h-4" style="color: #f59e0b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
              </div>
              <div>
                <div class="font-semibold text-sm" style="color: var(--text-primary);">{{ resume.job_title }}</div>
                <div class="text-xs" style="color: var(--text-secondary);">{{ resume.company_name || 'General' }} · {{ formatDate(resume.created_at) }}</div>
              </div>
            </div>
            <div class="flex items-center gap-4 text-xs" style="color: var(--text-secondary);">
              <span class="flex items-center gap-1" title="Views">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                {{ resume.views_count }}
              </span>
              <span class="flex items-center gap-1" title="Downloads">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                {{ resume.downloads_count }}
              </span>
            </div>
          </div>
        </div>
        <div v-else class="text-center py-16" style="color: var(--text-secondary);">
          <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
          <p class="text-sm font-medium" style="color: var(--text-primary);">No resumes generated yet</p>
          <p class="text-xs mt-1">Generate your first resume from the Resume Builder</p>
        </div>
      </div>
    </div>

    <!-- Third Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      <!-- Featured Skills -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">⚡</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Top Skills</h3>
          </div>
          <Link :href="route('admin.skills.index')" class="text-xs font-medium transition" style="color: var(--text-secondary);"
                @mouseenter="$event.target.style.color = 'var(--accent)'" @mouseleave="$event.target.style.color = 'var(--text-secondary)'">
            View All →
          </Link>
        </div>
        <div class="p-4 space-y-2">
          <div v-for="skill in featuredSkills" :key="skill.id"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl transition"
               @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
               @mouseleave="$event.currentTarget.style.background = 'transparent'">
            <div>
              <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ skill.name }}</span>
              <span class="text-[10px] ml-2 px-1.5 py-0.5 rounded font-medium" style="background: var(--bg-tertiary); color: var(--text-secondary);">{{ skill.category }}</span>
            </div>
            <div class="flex items-center gap-2">
              <div class="w-16 h-1.5 rounded-full overflow-hidden" style="background: var(--bg-tertiary);">
                <div class="h-full rounded-full" :style="{ width: skill.proficiency_level + '%', background: 'var(--accent)' }"></div>
              </div>
              <span class="text-[10px] font-semibold w-7 text-right" style="color: var(--text-secondary);">{{ skill.proficiency_level }}%</span>
            </div>
          </div>
          <div v-if="!featuredSkills.length" class="text-center py-6">
            <p class="text-xs" style="color: var(--text-secondary);">No featured skills yet</p>
          </div>
        </div>
      </div>

      <!-- Recent Projects -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="flex items-center justify-between px-6 py-4" style="border-bottom: 1px solid var(--border-color);">
          <div class="flex items-center gap-2">
            <span class="text-base">🚀</span>
            <h3 class="text-base font-bold" style="color: var(--text-primary);">Recent Projects</h3>
          </div>
          <Link :href="route('admin.projects.index')" class="text-xs font-medium transition" style="color: var(--text-secondary);"
                @mouseenter="$event.target.style.color = 'var(--accent)'" @mouseleave="$event.target.style.color = 'var(--text-secondary)'">
            View All →
          </Link>
        </div>
        <div class="p-4 space-y-2">
          <div v-for="proj in recentProjects" :key="proj.id"
               class="flex items-center justify-between px-3 py-2.5 rounded-xl transition"
               @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
               @mouseleave="$event.currentTarget.style.background = 'transparent'">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background: var(--bg-tertiary);">
                {{ proj.is_featured ? '⭐' : '📁' }}
              </div>
              <div>
                <span class="text-sm font-semibold" style="color: var(--text-primary);">{{ proj.title }}</span>
                <span class="text-[10px] ml-2 px-1.5 py-0.5 rounded font-medium" style="background: var(--bg-tertiary); color: var(--text-secondary);">{{ proj.project_type }}</span>
              </div>
            </div>
          </div>
          <div v-if="!recentProjects.length" class="text-center py-6">
            <p class="text-xs" style="color: var(--text-secondary);">No projects yet</p>
          </div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="rounded-2xl shadow-sm overflow-hidden" style="background: var(--bg-secondary); border: 1px solid var(--border-color);">
        <div class="px-6 py-4 flex items-center gap-2" style="border-bottom: 1px solid var(--border-color);">
          <span class="text-base">⚙️</span>
          <h3 class="text-base font-bold" style="color: var(--text-primary);">Quick Actions</h3>
        </div>
        <div class="p-3 space-y-1">
          <Link v-for="action in quickActions" :key="action.label" :href="action.href"
                class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all group"
                @mouseenter="$event.currentTarget.style.background = 'var(--bg-tertiary)'"
                @mouseleave="$event.currentTarget.style.background = 'transparent'">
            <span class="text-base w-7 text-center">{{ action.emoji }}</span>
            <div class="flex-1 min-w-0">
              <div class="text-sm font-semibold" style="color: var(--text-primary);">{{ action.label }}</div>
              <div class="text-[11px]" style="color: var(--text-secondary);">{{ action.desc }}</div>
            </div>
            <svg class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity flex-shrink-0" style="color: var(--accent);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
          </Link>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';

const props = defineProps({
  skillsCount: Number,
  experiencesCount: Number,
  projectsCount: Number,
  resumesCount: Number,
  educationCount: Number,
  certificationsCount: Number,
  contactsCount: Number,
  profileSectionsCount: Number,
  recentResumes: Array,
  siteName: String,
  siteTagline: String,
  siteProfileImage: String,
  siteIconLetter: String,
  bio: String,
  bioId: Number,
  objective: String,
  objectiveId: Number,
  featuredSkills: Array,
  recentProjects: Array,
  // Analytics props
  analytics: Object,
  dailyViews: Array,
  topPages: Array,
  deviceBreakdown: Array,
  browserBreakdown: Array,
  topReferrers: Array,
});

const formatDate = (d) => new Date(d).toLocaleDateString('en-US', { month: 'short', day: 'numeric' });

// --- Identity Form ---
const identityForm = useForm({
  settings: [
    { key: 'site_name', value: props.siteName || '' },
    { key: 'site_tagline', value: props.siteTagline || '' },
  ],
});

const objectiveContent = ref(props.objective || '');

const identitySaved = ref(false);
let identitySavedTimeout = null;

const saveIdentity = () => {
  identityForm.put(route('admin.settings.update'), {
    preserveScroll: true,
    onSuccess: () => {
      if (objectiveContent.value !== props.objective && props.objectiveId) {
        router.put(route('admin.profile-sections.update', props.objectiveId), {
          section_name: 'objective',
          title: '',
          content: objectiveContent.value,
          is_active: true,
          display_order: 0,
        }, { preserveScroll: true });
      }
      identitySaved.value = true;
      clearTimeout(identitySavedTimeout);
      identitySavedTimeout = setTimeout(() => { identitySaved.value = false; }, 3000);
    },
  });
};

// --- Bio Form ---
const bioForm = useForm({
  section_name: 'bio',
  title: '',
  content: props.bio || '',
  is_active: true,
  display_order: 0,
});

const bioSaved = ref(false);
let bioSavedTimeout = null;

const saveBio = () => {
  if (props.bioId) {
    bioForm.put(route('admin.profile-sections.update', props.bioId), {
      preserveScroll: true,
      onSuccess: () => {
        bioSaved.value = true;
        clearTimeout(bioSavedTimeout);
        bioSavedTimeout = setTimeout(() => { bioSaved.value = false; }, 3000);
      },
    });
  }
};

// --- Stats ---
const stats = [
  { label: 'Skills', value: props.skillsCount, emoji: '⚡', color: '#a855f7', href: route('admin.skills.index') },
  { label: 'Experience', value: props.experiencesCount, emoji: '💼', color: '#10b981', href: route('admin.experiences.index') },
  { label: 'Projects', value: props.projectsCount, emoji: '🚀', color: '#8b5cf6', href: route('admin.projects.index') },
  { label: 'Education', value: props.educationCount, emoji: '🎓', color: '#3b82f6', href: route('admin.education.index') },
  { label: 'Certificates', value: props.certificationsCount, emoji: '🏅', color: '#f59e0b', href: route('admin.certifications.index') },
  { label: 'Contacts', value: props.contactsCount, emoji: '📬', color: '#ec4899', href: route('admin.contact-info.index') },
  { label: 'Sections', value: props.profileSectionsCount, emoji: '👤', color: '#14b8a6', href: route('admin.profile-sections.index') },
  { label: 'Resumes', value: props.resumesCount, emoji: '📄', color: '#f97316', href: null },
];

// --- Completeness ---
const completenessChecklist = computed(() => [
  { label: 'Profile image uploaded', done: !!props.siteProfileImage },
  { label: 'Bio written', done: !!props.bio },
  { label: 'At least 3 skills', done: props.skillsCount >= 3 },
  { label: 'At least 1 experience', done: props.experiencesCount >= 1 },
  { label: 'At least 1 project', done: props.projectsCount >= 1 },
  { label: 'At least 1 education', done: props.educationCount >= 1 },
  { label: 'Contact info added', done: props.contactsCount >= 1 },
  { label: 'Site name configured', done: !!props.siteName },
]);

const completenessScore = computed(() => {
  const done = completenessChecklist.value.filter(c => c.done).length;
  return Math.round((done / completenessChecklist.value.length) * 100);
});

const completenessColor = computed(() => {
  if (completenessScore.value >= 80) return '#10b981';
  if (completenessScore.value >= 50) return '#f59e0b';
  return '#ef4444';
});

// --- Quick Actions ---
const quickActions = [
  { label: 'Add Skill', emoji: '⚡', href: route('admin.skills.index'), desc: 'Add a new technology' },
  { label: 'Add Experience', emoji: '💼', href: route('admin.experiences.index'), desc: 'Log work history' },
  { label: 'Add Project', emoji: '🚀', href: route('admin.projects.index'), desc: 'Showcase your work' },
  { label: 'Site Settings', emoji: '🎨', href: route('admin.settings.index'), desc: 'Branding & identity' },
  { label: 'Theme', emoji: '🖌️', href: route('admin.theme.index'), desc: 'Colors & appearance' },
];

// --- Analytics Helpers ---
const analytics = computed(() => props.analytics || {});
const dailyViews = computed(() => props.dailyViews || []);
const topPages = computed(() => props.topPages || []);
const deviceBreakdown = computed(() => props.deviceBreakdown || []);
const browserBreakdown = computed(() => props.browserBreakdown || []);
const topReferrers = computed(() => props.topReferrers || []);

const visitorStats = computed(() => [
  {
    label: 'Today',
    value: analytics.value.today || 0,
    sub: `${analytics.value.uniqueToday || 0} unique visitors`,
    color: '#10b981',
    icon: 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
  },
  {
    label: 'Yesterday',
    value: analytics.value.yesterday || 0,
    sub: null,
    color: '#8b5cf6',
    icon: 'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
  },
  {
    label: 'This Month',
    value: analytics.value.thisMonth || 0,
    sub: `${analytics.value.uniqueThisMonth || 0} unique visitors`,
    color: '#3b82f6',
    icon: 'M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z',
  },
  {
    label: 'All Time',
    value: analytics.value.total || 0,
    sub: null,
    color: '#f59e0b',
    icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
  },
]);

const chartMaxViews = computed(() => Math.max(...dailyViews.value.map(d => d.views), 1));

const chartBarHeight = (views) => {
  if (!views || chartMaxViews.value === 0) return 2;
  return Math.max(2, Math.round((views / chartMaxViews.value) * 130));
};

const totalDeviceViews = computed(() => deviceBreakdown.value.reduce((sum, d) => sum + d.count, 0) || 1);
const devicePercent = (count) => Math.round((count / totalDeviceViews.value) * 100);
const deviceEmoji = (device) => ({ desktop: '🖥️', mobile: '📱', tablet: '📟', unknown: '❓' }[device] || '❓');
const deviceColor = (device) => ({ desktop: '#3b82f6', mobile: '#10b981', tablet: '#f59e0b', unknown: '#6b7280' }[device] || '#6b7280');

const totalBrowserViews = computed(() => browserBreakdown.value.reduce((sum, b) => sum + b.count, 0) || 1);
const browserPercent = (count) => Math.round((count / totalBrowserViews.value) * 100);
const browserColor = (browser) => {
  const colors = { Chrome: '#4285f4', Firefox: '#ff7139', Safari: '#0fb5ee', Edge: '#0078d4', Opera: '#ff1b2d', IE: '#1ebbee', Other: '#6b7280' };
  return colors[browser] || '#6b7280';
};

const shortenUrl = (url) => {
  try {
    const u = new URL(url);
    return u.hostname.replace('www.', '');
  } catch {
    return url?.substring(0, 30) || 'Direct';
  }
};
</script>
