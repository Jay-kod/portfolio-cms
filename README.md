<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12">
  <img src="https://img.shields.io/badge/Vue.js-3-4FC08D?style=for-the-badge&logo=vuedotjs&logoColor=white" alt="Vue 3">
  <img src="https://img.shields.io/badge/Inertia.js-2-9553E9?style=for-the-badge&logo=inertia&logoColor=white" alt="Inertia.js 2">
  <img src="https://img.shields.io/badge/Tailwind_CSS-4-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white" alt="Tailwind CSS 4">
  <img src="https://img.shields.io/badge/Vite-7-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite 7">
  <img src="https://img.shields.io/badge/MySQL-8-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL 8">
</p>

<h1 align="center">🚀 jaykod.io — Portfolio CMS</h1>

<p align="center">
  A full-featured, self-hosted portfolio content management system with an AI-powered resume generator.<br>
  Built with <strong>Laravel 12</strong>, <strong>Vue 3</strong>, <strong>Inertia.js</strong>, and <strong>Tailwind CSS 4</strong>.
</p>

<p align="center">
  <a href="#-features">Features</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-architecture">Architecture</a> •
  <a href="#-getting-started">Getting Started</a> •
  <a href="#-docker-deployment">Docker</a> •
  <a href="#-api-reference">API</a> •
  <a href="#-project-structure">Structure</a> •
  <a href="#-contributing">Contributing</a>
</p>

---

## ✨ Features

### 🎨 Public Portfolio
- **Dynamic Landing Page** — Hero section with live availability status badge, animated tech stack showcase, featured projects carousel, and interactive stats counter
- **About Page** — Profile sections (bio, specialties, philosophy), skills with proficiency bars and category grouping, certification badges with expiration tracking
- **Experience Timeline** — Chronological work history with achievement highlights, technology tags, and current-role indicators
- **Project Gallery** — Filterable project cards with descriptions, tech stacks, tags, live/GitHub links, and featured project pinning
- **Contact Page** — Social links (LinkedIn, GitHub, Twitter, etc.), email, phone, and location info managed from the admin panel
- **SEO Optimized** — Dynamic meta tags (Open Graph, description, title) per page via Inertia `<Head>`, auto-generated `sitemap.xml`
- **Page View Tracking** — Anonymous analytics tracking visitor counts per route

### 📄 AI-Powered Resume Generator
- **Job Description Analysis** — Paste a job posting and the system extracts keywords, required skills, and role context to tailor your resume
- **Smart Content Selection** — `ContentSelectorService` scores and ranks your skills, experiences, projects, education, and certifications for relevance to each specific job
- **Multiple Templates** — Choose from professional resume templates (e.g., Professional, Modern Minimal) rendered as PDF via DomPDF
- **Shareable Links** — Each generated resume gets a unique token-based URL with optional expiration
- **Download as PDF** — One-click PDF download with path-traversal protection

### 🛠 Admin Dashboard
- **Full CRUD Management** — Create, read, update, and delete: skills, experiences, projects, education, certifications, profile sections, contact info, and resume templates
- **Site Settings** — Configure site name, tagline, social links, profile image, and meta defaults from a centralized settings page
- **Theme Customization** — Live-preview color theme editor (primary, secondary, accent, background colors) with one-click reset to defaults
- **Database Manager** — In-browser database backup/restore, migration runner, seeder execution, cache clearing, and table inspection
- **File Uploads** — Drag-and-drop image uploads for projects, profile photos, and certifications (JPEG, PNG, WebP, SVG — max 2MB)
- **Flash Notifications** — Success/error toast messages on all admin actions

### 🔒 Security
- **Sanctum Authentication** — Token-based API auth with 24-hour expiration, session-based web auth
- **Protected Registration** — Admin-only user creation (no public registration)
- **Rate Limiting** — Tiered throttling: 5/min for auth, 10/min for resume generation, 30/min for public resume viewing, 60/min for portfolio API
- **Input Validation** — Comprehensive request validation on all endpoints with `sometimes` modifier for updates
- **Password Reset Flow** — Email-based password recovery with signed URLs
- **Email Verification** — Required email verification for new admin accounts
- **Path Traversal Protection** — Sanitized PDF download paths
- **CSRF Protection** — Automatic on all web routes via Laravel middleware

---

## 🏗 Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Backend Framework** | Laravel | 12.x |
| **Frontend Framework** | Vue.js | 3.5 |
| **SPA Bridge** | Inertia.js | 2.x |
| **CSS Framework** | Tailwind CSS | 4.x |
| **Build Tool** | Vite | 7.x |
| **Database** | MySQL | 8.0 |
| **Auth** | Laravel Sanctum | 4.3 |
| **PDF Generation** | barryvdh/laravel-dompdf | 3.1 |
| **URL Generation** | Ziggy (tightenco/ziggy) | 2.6 |
| **UI Components** | Headless UI + Heroicons | 1.7 / 2.2 |
| **Progress Bar** | NProgress | 0.2 |
| **Testing** | PHPUnit | 11.5 |
| **Code Style** | Laravel Pint | 1.24 |
| **Containerization** | Docker + Docker Compose | 3.8 spec |

---

## 📐 Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                         Browser                              │
│  ┌─────────────┐  ┌──────────────┐  ┌────────────────────┐  │
│  │ Portfolio    │  │ Admin Panel  │  │ Resume Builder     │  │
│  │ (Vue + TW)  │  │ (Vue + TW)   │  │ (Vue + TW)         │  │
│  └──────┬──────┘  └──────┬───────┘  └────────┬───────────┘  │
│         │                │                    │              │
│         └────────────────┼────────────────────┘              │
│                          │ Inertia.js (no API needed)        │
└──────────────────────────┼───────────────────────────────────┘
                           │
┌──────────────────────────┼───────────────────────────────────┐
│                    Laravel 12 Backend                         │
│  ┌───────────────┐  ┌────┴────────┐  ┌────────────────────┐ │
│  │ Web Routes    │  │ API Routes  │  │ Services           │ │
│  │ (Inertia)     │  │ (Sanctum)   │  │ • ContentSelector  │ │
│  │ • Portfolio    │  │ • Auth      │  │ • PdfGenerator     │ │
│  │ • Admin CRUD  │  │ • Admin CRUD│  │                    │ │
│  │ • Auth        │  │ • Portfolio  │  └────────────────────┘ │
│  │ • Resume      │  │ • Resume    │                          │
│  └───────────────┘  └─────────────┘                          │
│                          │                                    │
│  ┌───────────────────────┼───────────────────────────────┐   │
│  │              Eloquent ORM + Migrations                │   │
│  │  Models: User, Skill, Experience, Project, Education, │   │
│  │  Certification, ProfileSection, ContactInfo,          │   │
│  │  ResumeTemplate, ResumeGeneration, SiteSetting,       │   │
│  │  PageView                                              │   │
│  └───────────────────────┬───────────────────────────────┘   │
└──────────────────────────┼───────────────────────────────────┘
                           │
                    ┌──────┴──────┐
                    │  MySQL 8.0  │
                    └─────────────┘
```

### Three Rendering Contexts

| Context | Layout | Auth | Description |
|---------|--------|------|-------------|
| **Portfolio** | `PortfolioLayout.vue` | Public | Dark theme (`#0a0a0a`), green accent (`#00ff88`), animated nav, footer |
| **Admin** | `AdminLayout.vue` | Required | Collapsible sidebar, DB-driven theme colors, breadcrumbs, flash messages |
| **Resume** | `ResumeLayout.vue` | Public | Light theme, step wizard indicator, minimal UI |

---

## 🚀 Getting Started

### Prerequisites

- **PHP** >= 8.2 with extensions: `pdo_mysql`, `mbstring`, `exif`, `pcntl`, `bcmath`, `gd`, `zip`
- **Composer** >= 2.x
- **Node.js** >= 18.x with npm
- **MySQL** >= 8.0 (or MariaDB 10.6+)

### Quick Setup

```bash
# 1. Clone the repository
git clone https://github.com/Jay-kod/portfolio-cms.git
cd portfolio-cms/backend

# 2. Install all dependencies
composer install
npm install

# 3. Configure environment
cp .env.example .env
php artisan key:generate
```

### Database Configuration

Edit `backend/.env` with your MySQL credentials:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portfolio_cms
DB_USERNAME=root
DB_PASSWORD=your_password
```

Then run migrations and seed demo data:

```bash
php artisan migrate
php artisan db:seed
```

### Running the Application

**Option A: Concurrent dev server (recommended)**
```bash
composer dev
```
This starts all four services simultaneously:
| Service | URL | Description |
|---------|-----|-------------|
| Laravel Server | `http://localhost:8000` | PHP backend |
| Vite Dev Server | `http://localhost:5173` | Hot-reload frontend |
| Queue Worker | — | Background job processing |
| Pail Log Viewer | — | Real-time log tailing |

**Option B: Manual startup**
```bash
# Terminal 1: Backend
php artisan serve

# Terminal 2: Frontend (hot reload)
npm run dev
```

### Building for Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 🐳 Docker Deployment

The project includes a full Docker Compose stack:

```bash
# Build and start all containers
docker compose up -d --build

# Run migrations inside the container
docker compose exec app php artisan migrate --seed
```

### Container Architecture

| Container | Image | Port | Role |
|-----------|-------|------|------|
| `portfolio-app` | PHP 8.2-FPM | 9000 (internal) | Laravel backend |
| `portfolio-web` | Nginx | 80 | Reverse proxy + static files |
| `portfolio-db` | MySQL 8.0 | 3306 | Database |

### Docker Environment Variables

```yaml
DB_CONNECTION: mysql
DB_HOST: db
DB_PORT: 3306
DB_DATABASE: portfolio_cms
DB_USERNAME: root
DB_PASSWORD: rootpassword
APP_URL: http://localhost
```

---

## 📡 API Reference

All API routes are prefixed with `/api` and return JSON. Protected routes require a `Bearer` token via Laravel Sanctum.

### Authentication

| Method | Endpoint | Auth | Rate Limit | Description |
|--------|----------|------|------------|-------------|
| `POST` | `/api/auth/login` | — | 5/min | Login, returns Sanctum token |
| `POST` | `/api/auth/logout` | Bearer | — | Revoke current token |
| `GET` | `/api/auth/user` | Bearer | — | Get authenticated user |
| `POST` | `/api/admin/auth/register` | Bearer + Admin | — | Create new admin user |

### Admin CRUD (all require Bearer + Admin role)

| Resource | Endpoints | Description |
|----------|-----------|-------------|
| Skills | `GET/POST/PUT/DELETE` `/api/admin/skills` | Programming skills & proficiency |
| Experiences | `GET/POST/PUT/DELETE` `/api/admin/experiences` | Work history entries |
| Projects | `GET/POST/PUT/DELETE` `/api/admin/projects` | Portfolio projects |
| Education | `GET/POST/PUT/DELETE` `/api/admin/education` | Degrees & coursework |
| Certifications | `GET/POST/PUT/DELETE` `/api/admin/certifications` | Professional certs |
| Profile Sections | `GET/POST/PUT/DELETE` `/api/admin/profile-sections` | Bio, about me, etc. |
| Contact Info | `GET/POST/PUT/DELETE` `/api/admin/contact-info` | Social links, email, phone |
| Templates | `GET/POST/PUT/DELETE` `/api/admin/templates` | Resume templates |

### Resume Generation

| Method | Endpoint | Auth | Rate Limit | Description |
|--------|----------|------|------------|-------------|
| `POST` | `/api/resumes/analyze` | Bearer | 10/min | Analyze job description & score content |
| `POST` | `/api/resumes/generate` | Bearer | 10/min | Generate tailored PDF resume |
| `GET` | `/api/resumes/{token}` | — | 30/min | View generated resume by token |
| `GET` | `/api/resumes/{token}/download` | — | 30/min | Download resume PDF |

### Public Portfolio

| Method | Endpoint | Rate Limit | Description |
|--------|----------|------------|-------------|
| `GET` | `/api/portfolio/full` | 60/min | Complete portfolio data |
| `GET` | `/api/portfolio/profile` | 60/min | Profile sections only |
| `GET` | `/api/portfolio/skills` | 60/min | Skills list |
| `GET` | `/api/portfolio/experiences` | 60/min | Work experiences |
| `GET` | `/api/portfolio/projects` | 60/min | Projects |
| `GET` | `/api/portfolio/education` | 60/min | Education entries |
| `GET` | `/api/portfolio/certifications` | 60/min | Certifications |
| `GET` | `/api/portfolio/contact` | 60/min | Contact information |

---

## 📁 Project Structure

```
portfolio-cms/
├── docker-compose.yml          # Docker orchestration (app + web + db)
├── nginx/
│   └── default.conf            # Nginx reverse proxy config
├── backend/
│   ├── app/
│   │   ├── Http/
│   │   │   ├── Controllers/
│   │   │   │   ├── Admin/              # Web admin controllers (Inertia)
│   │   │   │   │   ├── AuthController.php
│   │   │   │   │   ├── DashboardController.php
│   │   │   │   │   ├── SkillController.php
│   │   │   │   │   ├── ExperienceController.php
│   │   │   │   │   ├── ProjectController.php
│   │   │   │   │   ├── EducationController.php
│   │   │   │   │   ├── CertificationController.php
│   │   │   │   │   ├── ProfileSectionController.php
│   │   │   │   │   ├── ContactInfoController.php
│   │   │   │   │   ├── ResumeTemplateController.php
│   │   │   │   │   ├── SiteSettingsController.php
│   │   │   │   │   ├── ThemeController.php
│   │   │   │   │   ├── DatabaseController.php
│   │   │   │   │   ├── FileUploadController.php
│   │   │   │   │   ├── PasswordResetController.php
│   │   │   │   │   └── EmailVerificationController.php
│   │   │   │   ├── API/                # JSON API controllers (Sanctum)
│   │   │   │   │   ├── Admin/          # Protected admin API
│   │   │   │   │   ├── AuthController.php
│   │   │   │   │   ├── PortfolioController.php
│   │   │   │   │   └── ResumeController.php
│   │   │   │   ├── PortfolioPageController.php   # Public Inertia pages
│   │   │   │   ├── ResumePageController.php      # Resume builder pages
│   │   │   │   └── SitemapController.php         # sitemap.xml
│   │   │   └── Middleware/
│   │   │       ├── HandleInertiaRequests.php      # Shared Inertia data
│   │   │       ├── EnsureUserHasRole.php          # Role-based access
│   │   │       └── TrackPageView.php              # Analytics tracking
│   │   ├── Models/
│   │   │   ├── User.php               # Admin user (MustVerifyEmail)
│   │   │   ├── Skill.php              # Skills with proficiency & categories
│   │   │   ├── Experience.php         # Work history
│   │   │   ├── Project.php            # Portfolio projects
│   │   │   ├── Education.php          # Degrees & education
│   │   │   ├── Certification.php      # Professional certifications
│   │   │   ├── ProfileSection.php     # Bio, about, philosophy sections
│   │   │   ├── ContactInfo.php        # Social links & contact details
│   │   │   ├── ResumeTemplate.php     # PDF template definitions
│   │   │   ├── ResumeGeneration.php   # Generated resume records
│   │   │   ├── SiteSetting.php        # Key-value site configuration
│   │   │   └── PageView.php           # Visitor tracking
│   │   └── Services/
│   │       ├── ContentSelectorService.php  # AI content scoring for resumes
│   │       └── PdfGeneratorService.php     # DomPDF resume generation
│   ├── database/
│   │   ├── migrations/         # 18 migrations for all tables
│   │   └── seeders/            # Demo data seeders
│   ├── resources/
│   │   ├── css/app.css         # Tailwind CSS entry point
│   │   ├── js/
│   │   │   ├── app.js          # Inertia + Vue app bootstrap
│   │   │   ├── Layouts/
│   │   │   │   ├── PortfolioLayout.vue   # Public site layout
│   │   │   │   ├── AdminLayout.vue       # Admin panel layout
│   │   │   │   └── ResumeLayout.vue      # Resume builder layout
│   │   │   └── Pages/
│   │   │       ├── Portfolio/  # 6 public pages (Index, About, Experience, Projects, Contact, + legacy)
│   │   │       ├── Admin/      # 12 admin pages (Dashboard, CRUD, Settings, Theme, Database)
│   │   │       ├── Auth/       # 4 auth pages (Login, ForgotPassword, ResetPassword, VerifyEmail)
│   │   │       ├── Resume/     # 2 resume pages (Create wizard, View)
│   │   │       └── Errors/     # Error pages (404, 403, 500, 503)
│   │   └── views/
│   │       ├── app.blade.php   # Root Blade template (Inertia entry)
│   │       └── resumes/        # PDF Blade templates
│   ├── routes/
│   │   ├── web.php             # Inertia routes (portfolio, admin, auth)
│   │   ├── api.php             # JSON API routes (Sanctum-protected)
│   │   └── console.php         # Artisan command scheduling
│   ├── config/                 # Laravel config (sanctum, database, etc.)
│   ├── storage/                # File uploads, logs, cache, generated PDFs
│   ├── composer.json           # PHP dependencies
│   └── package.json            # Node.js dependencies
└── TASKS.md                    # Development task tracker (40 tasks, 6 phases)
```

---

## 🗄 Database Schema

### Core Models

| Model | Table | Key Fields |
|-------|-------|------------|
| **User** | `users` | name, email, password, role, email_verified_at |
| **Skill** | `skills` | name, category, proficiency_level, is_active, display_order |
| **Experience** | `experiences` | company, position, start_date, end_date, is_current, description, achievements[], technologies_used[] |
| **Project** | `projects` | title, description, technologies_used[], tags[], live_url, github_url, is_featured, display_order |
| **Education** | `education` | institution, degree, field_of_study, start_date, end_date, is_current, description, achievements[] |
| **Certification** | `certifications` | name, issuing_organization, issue_date, expiry_date, credential_id, credential_url |
| **ProfileSection** | `profile_sections` | title, key, content, type, metadata, display_order |
| **ContactInfo** | `contact_info` | type, value, label, icon, display_order, is_primary |
| **ResumeTemplate** | `resume_templates` | name, slug, description, template_path, is_active |
| **ResumeGeneration** | `resume_generations` | token, template_id, job_title, company_name, job_description, selected_skills/experiences/projects/education/certifications, generated_pdf_path, expires_at |
| **SiteSetting** | `site_settings` | key, value (longtext) |
| **PageView** | `page_views` | path, ip_address, user_agent, referrer |

---

## ⚙️ Configuration

### Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `APP_NAME` | `Laravel` | Site name displayed in nav and title |
| `APP_ENV` | `local` | Environment (`local`, `production`) |
| `APP_DEBUG` | `true` | Show debug errors (disable in production!) |
| `APP_URL` | `http://localhost` | Base URL for the application |
| `DB_CONNECTION` | `sqlite` | Database driver (`mysql` for production) |
| `DB_HOST` | `127.0.0.1` | Database host |
| `DB_DATABASE` | `portfolio_cms` | Database name |
| `SANCTUM_TOKEN_EXPIRATION` | `1440` | API token lifetime in minutes (24h) |
| `MAIL_MAILER` | `log` | Mail driver for password resets & verification |
| `LOG_CHANNEL` | `stack` | Logging channel (`daily` recommended for prod) |

### Mail Configuration (for password reset & email verification)

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=your_app_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@jaykod.io
MAIL_FROM_NAME="jaykod.io"
```

---

## 🧪 Testing

```bash
cd backend

# Run all tests
php artisan test

# Run with coverage
php artisan test --coverage

# Run specific test suite
php artisan test --testsuite=Feature
php artisan test --testsuite=Unit

# Code style check
./vendor/bin/pint --test

# Auto-fix code style
./vendor/bin/pint
```

---

## 🔧 Useful Commands

```bash
# Development
composer dev                    # Start all dev services (server + vite + queue + logs)
php artisan serve               # Start PHP dev server only
npm run dev                     # Start Vite HMR only
npm run build                   # Build frontend for production

# Database
php artisan migrate             # Run pending migrations
php artisan migrate:fresh --seed # Reset DB and seed demo data
php artisan db:seed             # Seed demo data

# Maintenance
php artisan config:cache        # Cache configuration
php artisan route:cache         # Cache routes
php artisan view:cache          # Cache Blade views
php artisan cache:clear         # Clear application cache
php artisan storage:link        # Create public storage symlink

# Code Quality
./vendor/bin/pint               # Fix code style (PSR-12)
php artisan test                # Run test suite
```

---

## 🗺 Roadmap

See [TASKS.md](TASKS.md) for the complete 40-task development roadmap across 6 phases:

- ✅ **Phase 1** — Critical Security Fixes (T-01 → T-05)
- ✅ **Phase 2** — High Priority Fixes (T-06 → T-14)
- ✅ **Phase 3** — Validation & Data Integrity (T-15 → T-22)
- 🔲 **Phase 4** — Code Quality & Architecture (T-23 → T-30)
- 🔲 **Phase 5** — Performance & DevOps (T-31 → T-36)
- 🔲 **Phase 6** — Feature Enhancements (T-37 → T-40)

---

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Make your changes and add tests
4. Run the linter: `./vendor/bin/pint`
5. Run tests: `php artisan test`
6. Commit: `git commit -m "feat: add my feature"`
7. Push: `git push origin feature/my-feature`
8. Open a Pull Request

### Commit Convention

| Prefix | Usage |
|--------|-------|
| `feat:` | New feature |
| `fix:` | Bug fix |
| `docs:` | Documentation only |
| `style:` | Code formatting (no logic change) |
| `refactor:` | Code restructuring |
| `test:` | Adding/updating tests |
| `chore:` | Build, config, dependency changes |

---

## 📄 License

This project is open-sourced under the [MIT License](https://opensource.org/licenses/MIT).

---

<p align="center">
  Built with ❤️ by <a href="https://github.com/Jay-kod">Jay-kod</a>
</p>
