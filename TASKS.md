# jaykod.io Portfolio CMS — Rectification Task List

> Generated: February 17, 2026
> Total: 40 tasks across 6 phases

---

## Phase 1: Critical Security Fixes

- [x] **T-01** Remove or protect public admin registration
  - File: `backend/app/Http/Controllers/API/AuthController.php`
  - The `register()` endpoint is fully public and hardcodes `role => 'admin'` — anyone can create an admin account
  - Fix: Remove the route entirely, or gate it behind existing admin auth so only admins can create new users

- [x] **T-02** Add input validation to all `update()` methods using `$request->all()`
  - Files:
    - `backend/app/Http/Controllers/Admin/ExperienceController.php`
    - `backend/app/Http/Controllers/Admin/ProjectController.php`
    - `backend/app/Http/Controllers/Admin/ResumeTemplateController.php`
    - `backend/app/Http/Controllers/API/Admin/CertificationController.php`
    - `backend/app/Http/Controllers/API/Admin/ContactInfoController.php`
    - `backend/app/Http/Controllers/API/Admin/EducationController.php`
    - `backend/app/Http/Controllers/API/Admin/ExperienceController.php`
    - `backend/app/Http/Controllers/API/Admin/ProfileSectionController.php`
    - `backend/app/Http/Controllers/API/Admin/ProjectController.php`
    - `backend/app/Http/Controllers/API/Admin/ResumeTemplateController.php`
  - Replace every `$model->update($request->all())` with proper `$request->validate([...])` matching the `store()` rules (using `sometimes` modifier)

- [x] **T-03** Add rate limiting to all routes
  - File: `backend/bootstrap/app.php`
  - Add `throttle:60,1` to web login route
  - Add `throttle:api` (default 60/min) to all API route groups
  - Add stricter `throttle:5,1` to auth endpoints (login, register)
  - Add `throttle:10,1` to resume generation endpoints

- [x] **T-04** Set Sanctum token expiration
  - File: `backend/config/sanctum.php`
  - Change `'expiration' => null` to `'expiration' => env('SANCTUM_TOKEN_EXPIRATION', 1440)` (24 hours)

- [x] **T-05** Sanitize PDF download path to prevent path traversal
  - File: `backend/app/Http/Controllers/API/ResumeController.php`
  - Validate that `$resume->generated_pdf_path` starts with `public/resumes/` and contains no `..` segments before passing to `storage_path()`

---

## Phase 2: High Priority Fixes

- [x] **T-06** Implement password reset flow
  - Create `ForgotPasswordController` and `ResetPasswordController`
  - Add routes: `POST /admin/forgot-password`, `POST /admin/reset-password`
  - Add `password_reset_tokens` migration (already in default Laravel users migration)
  - Wire up the existing "forgot password" UI in `Login.vue` to the new endpoints
  - Configure mail driver in `.env`

- [x] **T-07** Fix `Skill::scopeActive()` no-op
  - File: `backend/app/Models/Skill.php`
  - Either: add `is_active` column via migration + filter in scope, or remove the scope if skills are always active
  - Check if the `skills` migration already has `is_active` — if not, create a migration to add it

- [x] **T-08** Add pagination to all API list endpoints
  - Files: all controllers in `backend/app/Http/Controllers/API/`
  - Replace `->get()` with `->paginate(25)` in all `index()` / list methods
  - Update `PortfolioController::full()` to paginate or cap results

- [x] **T-09** Add caching to shared Inertia data and SiteSetting queries
  - File: `backend/app/Models/SiteSetting.php` — wrap `allAsArray()` and `getValue()` in `Cache::remember('site_settings', 3600, ...)`
  - File: `backend/app/Http/Middleware/HandleInertiaRequests.php` — cache `socialLinks` and `themeColors`
  - Bust cache in `SiteSettingsController::update()` and `ThemeController::update()`/`reset()`

- [x] **T-10** Add SEO meta tags to all public pages
  - File: `backend/resources/views/app.blade.php` — add dynamic `<meta>` tags via Inertia head
  - File: `backend/app/Http/Controllers/PortfolioPageController.php` — pass `meta` prop (title, description, og:image) per page
  - Use `<Head>` component from `@inertiajs/vue3` in each portfolio page

- [x] **T-11** Add sitemap.xml generation
  - Install `spatie/laravel-sitemap` or create a manual `/sitemap.xml` route
  - Include all 7 public portfolio pages with proper priorities and changefreq

- [x] **T-12** Add file/image upload support
  - Create `FileUploadController` with `store()` and `destroy()` methods
  - Add routes: `POST /admin/uploads`, `DELETE /admin/uploads/{id}`
  - Support project screenshots, profile photos, certification badge images
  - Add `image_path` field to relevant models if needed
  - Validate file type (jpeg, png, webp, svg) and size (max 2MB)
  - Store in `storage/app/public/uploads/` with `storage:link`

- [x] **T-13** Add email verification for users
  - File: `backend/app/Models/User.php` — implement `MustVerifyEmail` interface
  - Add verification routes and controller
  - Update login flow to check `email_verified_at`

- [x] **T-14** Require authentication for resume generation API
  - File: `backend/routes/api.php` — move `resumes/analyze` and `resumes/generate` inside `auth:sanctum` middleware group, or add a separate rate-limited guest throttle

---

## Phase 3: Validation & Data Integrity

- [x] **T-15** Add conditional validation for `end_date` / `is_current`
  - Files: `ExperienceController`, `EducationController` (both web + API)
  - Rules: `'end_date' => 'required_if:is_current,false|nullable|date|after_or_equal:start_date'`
  - When `is_current` is true, `end_date` should be nullable

- [x] **T-16** Validate array item types and lengths
  - Files: all controllers that accept `achievements`, `technologies_used`, `tags`, `highlights`
  - Add rules like: `'achievements.*' => 'string|max:500'`, `'technologies.*' => 'string|max:100'`, `'tags.*' => 'string|max:50'`

- [x] **T-17** Add `max` length to text fields
  - All controllers: add `'description' => 'nullable|string|max:5000'`, `'content' => 'nullable|string|max:10000'`
  - Resume generation: `'custom_objective' => 'nullable|string|max:2000'`, `'additional_notes' => 'nullable|string|max:2000'`

- [x] **T-18** Validate `expiry_date` is after `issue_date` in CertificationController
  - Add rule: `'expiry_date' => 'nullable|date|after_or_equal:issue_date'`

- [x] **T-19** Add type-specific validation to ContactInfo `value` field
  - When `type=email`, validate as email; when `type=phone`, validate as phone pattern; when type is a URL-based platform (linkedin, github, etc.), validate as URL

- [x] **T-20** Validate `selected_*` arrays in ResumeController
  - Add rules: `'selected_skills.*' => 'integer|exists:skills,id'`, same for experiences, projects, education, certifications

- [x] **T-21** Wrap batch operations in database transactions
  - Files: `SiteSettingsController::update()`, `ThemeController::update()`, `ThemeController::reset()`
  - Wrap the foreach loops in `DB::transaction(function () { ... })`

- [x] **T-22** Constrain SiteSettings keys to a whitelist
  - File: `backend/app/Http/Controllers/Admin/SiteSettingsController.php`
  - Validate `settings.*.key` against allowed keys from the DB or a constant array

---

## Phase 4: Code Quality & Architecture

- [ ] **T-23** Add soft deletes to key models
  - Models: `ResumeTemplate`, `ResumeGeneration`, `Project`, `Experience`
  - Add `SoftDeletes` trait and create migration to add `deleted_at` column
  - Update `destroy()` methods — hard-delete becomes soft-delete
  - Add admin UI to view/restore deleted items (optional)

- [ ] **T-24** Configure `AppServiceProvider::boot()`
  - File: `backend/app/Providers/AppServiceProvider.php`
  - Add `Model::preventLazyLoading(!app()->isProduction())` to catch N+1 queries in dev
  - Add `URL::forceScheme('https')` when `app()->isProduction()`
  - Add Vite prefetch strategy if desired

- [ ] **T-25** Add missing model scopes and helpers
  - `Certification`: add `scopeOrdered()`, `isExpired(): bool` helper
  - `Education`: add `scopeOrdered()` scope; consider adding `display_order` column
  - `Skill`: add `is_active` column + fix `scopeActive()` (see T-07)
  - `ResumeGeneration`: add `scopePublic()`, `scopeNotExpired()` scopes
  - `ResumeGeneration`: remove `views_count` and `downloads_count` from `$fillable`

- [ ] **T-26** Add error handling to PdfGeneratorService
  - File: `backend/app/Services/PdfGeneratorService.php`
  - Wrap DomPDF generation in try/catch
  - Validate template name before rendering view
  - Return structured response or throw custom exception

- [ ] **T-27** Add scheduled PDF cleanup
  - Create artisan command: `php artisan resumes:cleanup`
  - Delete generated PDFs older than 30 days (or based on `expires_at`)
  - Register in `routes/console.php` to run daily

- [ ] **T-28** Make DatabaseSeeder idempotent
  - File: `backend/database/seeders/DatabaseSeeder.php`
  - Replace all `create()` calls with `updateOrCreate()` or `firstOrCreate()`
  - Use `env('ADMIN_PASSWORD', 'password')` instead of hardcoded value
  - Consider splitting into per-model seeders for maintainability

- [ ] **T-29** Improve ContentSelectorService
  - File: `backend/app/Services/ContentSelectorService.php`
  - Add multi-word phrase support to keyword extraction
  - Extract magic-number thresholds to config or class constants
  - Add caching for repeated analyses of the same job description
  - Consider creating an interface for future AI-based implementation swap

- [ ] **T-30** Sanitize HTML content before rendering
  - Ensure `v-html` directives in Vue components only render sanitized content
  - Add server-side sanitization (e.g., `strip_tags()` or HTMLPurifier) for `ProfileSection.content` and any user-editable rich text
  - Or use a client-side sanitizer like DOMPurify

---

## Phase 5: Performance & DevOps

- [ ] **T-31** Enable lazy code splitting
  - File: `backend/resources/js/app.js`
  - Change `import.meta.glob('./Pages/**/*.vue', { eager: true })` to `import.meta.glob('./Pages/**/*.vue')` (removes `eager`)
  - Return `pages[...]` as a promise to enable route-based code splitting
  - This should reduce the 609KB JS bundle significantly

- [ ] **T-32** Switch logging to daily rotation for production
  - File: `backend/config/logging.php`
  - Change default stack channel from `single` to `daily`
  - Set `LOG_LEVEL=warning` in production `.env`

- [ ] **T-33** Update `.env.example` with correct defaults
  - Change `APP_NAME=Laravel` to `APP_NAME=jaykod.io`
  - Add `DB_CONNECTION=mysql` with commented MySQL config
  - Add `SANCTUM_TOKEN_EXPIRATION=1440`
  - Add `ADMIN_PASSWORD=` placeholder
  - Document `SANCTUM_STATEFUL_DOMAINS` for production
  - Remove stale AWS placeholders if unused

- [ ] **T-34** Fix Docker setup
  - File: `docker-compose.yml`
  - Debug and fix the broken build (both `docker-compose` and `docker compose` fail)
  - Ensure PHP 8.2, MySQL, Node.js, and Nginx containers work together
  - Add health checks and volume mounts

- [ ] **T-35** Fix `package.json` metadata
  - File: `backend/package.json`
  - Replace `description` field (currently contains Laravel README HTML) with proper description: `"description": "jaykod.io Portfolio CMS"`
  - Update `author` field

- [ ] **T-36** Add CI/CD pipeline
  - Create `.github/workflows/ci.yml` with: lint (Pint), test (PHPUnit), build (Vite)
  - Add deploy workflow for production (optional)

---

## Phase 6: Feature Enhancements

- [ ] **T-37** Add contact form submission
  - Create `ContactSubmission` model/migration with fields: name, email, subject, message, is_read, created_at
  - Add public `POST /contact` route with validation + rate limiting
  - Add admin page to view/manage submissions
  - Optional: send email notification on new submission

- [ ] **T-38** Add blog/articles section
  - Create `Article` model/migration: title, slug, content, excerpt, cover_image, tags, is_published, published_at
  - Add admin CRUD page
  - Add public `/blog` and `/blog/{slug}` routes
  - Add to portfolio navigation

- [ ] **T-39** Add accessibility improvements
  - Add `aria-label` attributes to icon-only buttons across all pages
  - Add skip-to-content link in `PortfolioLayout.vue`
  - Ensure all images have alt text
  - Test keyboard navigation on all interactive elements
  - Add `prefers-reduced-motion` media query support for animations

- [ ] **T-40** Add PWA / Service Worker support
  - Install `vite-plugin-pwa`
  - Create `manifest.json` with app name, icons, theme colors
  - Add basic offline fallback page
  - Enable install prompt for mobile users

---

## Execution Order Recommendation

```
Phase 1 (Critical Security)     → T-01 through T-05   → Do first, no exceptions
Phase 2 (High Priority)         → T-06 through T-14   → Do next sprint
Phase 3 (Validation)            → T-15 through T-22   → Can batch with Phase 2
Phase 4 (Code Quality)          → T-23 through T-30   → Refactoring sprint
Phase 5 (Performance & DevOps)  → T-31 through T-36   → Before production deploy
Phase 6 (Features)              → T-37 through T-40   → Post-launch enhancements
```
