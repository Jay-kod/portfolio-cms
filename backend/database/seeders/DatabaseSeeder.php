<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ProfileSection;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Project;
use App\Models\Education;
use App\Models\Certification;
use App\Models\ContactInfo;
use App\Models\ResumeTemplate;
use App\Models\SiteSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Users
        User::create([
            'name' => 'Portfolio Admin',
            'email' => 'admin@portfolio.cms',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2. Profile Sections
        ProfileSection::create([
            'section_name' => 'bio',
            'content' => 'Passionate Full Stack Developer with 5+ years of experience building scalable web applications. Expert in Laravel ecosystem and modern frontend frameworks.',
            'display_order' => 1,
        ]);

        ProfileSection::create([
            'section_name' => 'objective',
            'content' => 'Seeking a challenging role as a Senior Developer where I can leverage my expertise in Laravel and Vue.js/React to build innovative solutions.',
            'display_order' => 2,
        ]);

        // Highlights (What I Do cards)
        $highlights = [
            ['emoji' => '🚀', 'title' => 'Full Stack Development',  'desc' => 'End-to-end web applications from database design to polished UI.',  'iconBg' => 'bg-violet-100'],
            ['emoji' => '🧠', 'title' => 'AI Integration',          'desc' => 'Building intelligent features powered by LLMs and AI agents.',      'iconBg' => 'bg-pink-100'],
            ['emoji' => '🎨', 'title' => 'Clean UI/UX',             'desc' => 'Pixel-perfect, responsive interfaces with modern design systems.',  'iconBg' => 'bg-sky-100'],
            ['emoji' => '🔧', 'title' => 'Problem Solving',         'desc' => 'Debugging complex issues and optimizing system performance.',        'iconBg' => 'bg-amber-100'],
        ];

        foreach ($highlights as $i => $h) {
            ProfileSection::create([
                'section_name' => 'highlight',
                'title' => $h['title'],
                'content' => $h['desc'],
                'metadata' => ['emoji' => $h['emoji'], 'iconBg' => $h['iconBg']],
                'display_order' => 10 + $i,
                'is_active' => true,
            ]);
        }

        // Quick Facts
        $quickFacts = [
            ['emoji' => '💻', 'label' => 'Primary Stack',   'value' => 'Laravel + Vue.js + Tailwind'],
            ['emoji' => '📍', 'label' => 'Location',        'value' => 'Available Worldwide'],
            ['emoji' => '🎯', 'label' => 'Focus',           'value' => 'Web Apps & SaaS Products'],
            ['emoji' => '☕', 'label' => 'Fuel',            'value' => 'Coffee & Curiosity'],
            ['emoji' => '📚', 'label' => 'Always Learning', 'value' => 'AI, Cloud, DevOps'],
        ];

        foreach ($quickFacts as $i => $f) {
            ProfileSection::create([
                'section_name' => 'quick_fact',
                'title' => $f['label'],
                'content' => $f['value'],
                'metadata' => ['emoji' => $f['emoji']],
                'display_order' => 20 + $i,
                'is_active' => true,
            ]);
        }

        // 3. Skills — Comprehensive Technology Map
        $skills = [
            // ── Backend Development ──
            ['name' => 'PHP',            'category' => 'Backend',       'proficiency_level' => 92, 'years_of_experience' => 5,   'is_featured' => true,  'tags' => ['language', 'server-side']],
            ['name' => 'Laravel',        'category' => 'Backend',       'proficiency_level' => 90, 'years_of_experience' => 4,   'is_featured' => true,  'tags' => ['framework', 'MVC', 'REST API']],
            ['name' => 'Node.js',        'category' => 'Backend',       'proficiency_level' => 35, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['runtime', 'javascript']],
            ['name' => 'Python',         'category' => 'Backend',       'proficiency_level' => 30, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['language', 'scripting']],
            ['name' => 'REST APIs',      'category' => 'Backend',       'proficiency_level' => 88, 'years_of_experience' => 4,   'is_featured' => true,  'tags' => ['architecture', 'API']],
            ['name' => 'Livewire',       'category' => 'Backend',       'proficiency_level' => 60, 'years_of_experience' => 1.5, 'is_featured' => false, 'tags' => ['framework', 'laravel']],
            ['name' => 'Inertia.js',     'category' => 'Backend',       'proficiency_level' => 75, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['SPA', 'bridge']],

            // ── Frontend Development ──
            ['name' => 'HTML5',          'category' => 'Frontend',      'proficiency_level' => 95, 'years_of_experience' => 6,   'is_featured' => true,  'tags' => ['markup', 'web']],
            ['name' => 'CSS3',           'category' => 'Frontend',      'proficiency_level' => 90, 'years_of_experience' => 6,   'is_featured' => true,  'tags' => ['styling', 'web']],
            ['name' => 'Tailwind CSS',   'category' => 'Frontend',      'proficiency_level' => 92, 'years_of_experience' => 3,   'is_featured' => true,  'tags' => ['utility-first', 'CSS framework']],
            ['name' => 'Bootstrap',      'category' => 'Frontend',      'proficiency_level' => 85, 'years_of_experience' => 4,   'is_featured' => true,  'tags' => ['CSS framework', 'responsive']],
            ['name' => 'JavaScript',     'category' => 'Frontend',      'proficiency_level' => 70, 'years_of_experience' => 3,   'is_featured' => true,  'tags' => ['language', 'scripting']],
            ['name' => 'Vue.js',         'category' => 'Frontend',      'proficiency_level' => 55, 'years_of_experience' => 1.5, 'is_featured' => false, 'tags' => ['SPA', 'framework']],
            ['name' => 'Alpine.js',      'category' => 'Frontend',      'proficiency_level' => 60, 'years_of_experience' => 1.5, 'is_featured' => false, 'tags' => ['lightweight', 'reactive']],
            ['name' => 'React',          'category' => 'Frontend',      'proficiency_level' => 20, 'years_of_experience' => 0.3, 'is_featured' => false, 'tags' => ['SPA', 'framework']],
            ['name' => 'SASS / SCSS',    'category' => 'Frontend',      'proficiency_level' => 65, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['preprocessor', 'CSS']],
            ['name' => 'Responsive Design', 'category' => 'Frontend',   'proficiency_level' => 90, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['mobile-first', 'media queries']],

            // ── Databases ──
            ['name' => 'MySQL',          'category' => 'Database',      'proficiency_level' => 88, 'years_of_experience' => 5,   'is_featured' => true,  'tags' => ['relational', 'SQL']],
            ['name' => 'PostgreSQL',     'category' => 'Database',      'proficiency_level' => 72, 'years_of_experience' => 2,   'is_featured' => true,  'tags' => ['relational', 'SQL']],
            ['name' => 'SQLite',         'category' => 'Database',      'proficiency_level' => 70, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['embedded', 'lightweight']],
            ['name' => 'Redis',          'category' => 'Database',      'proficiency_level' => 40, 'years_of_experience' => 1,   'is_featured' => false, 'tags' => ['in-memory', 'cache']],
            ['name' => 'MongoDB',        'category' => 'Database',      'proficiency_level' => 25, 'years_of_experience' => 0.3, 'is_featured' => false, 'tags' => ['NoSQL', 'document']],
            ['name' => 'Database Design','category' => 'Database',      'proficiency_level' => 82, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['ERD', 'normalization']],

            // ── AI & Machine Learning ──
            ['name' => 'AI Fundamentals','category' => 'AI & ML',       'proficiency_level' => 70, 'years_of_experience' => 2,   'is_featured' => true,  'tags' => ['concepts', 'theory']],
            ['name' => 'AI Agents',      'category' => 'AI & ML',       'proficiency_level' => 68, 'years_of_experience' => 1.5, 'is_featured' => true,  'tags' => ['autonomous', 'LLM']],
            ['name' => 'Prompt Engineering', 'category' => 'AI & ML',   'proficiency_level' => 75, 'years_of_experience' => 2,   'is_featured' => true,  'tags' => ['LLM', 'GPT', 'Claude']],
            ['name' => 'LLM Integration','category' => 'AI & ML',       'proficiency_level' => 60, 'years_of_experience' => 1,   'is_featured' => false, 'tags' => ['API', 'OpenAI', 'Anthropic']],
            ['name' => 'Machine Learning','category' => 'AI & ML',      'proficiency_level' => 25, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['models', 'training']],
            ['name' => 'ChatGPT / Claude','category' => 'AI & ML',      'proficiency_level' => 80, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['productivity', 'assistants']],

            // ── DevOps & Cloud ──
            ['name' => 'Git / GitHub',   'category' => 'DevOps & Cloud','proficiency_level' => 78, 'years_of_experience' => 4,   'is_featured' => true,  'tags' => ['version control', 'collaboration']],
            ['name' => 'Linux / CLI',    'category' => 'DevOps & Cloud','proficiency_level' => 55, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['server', 'terminal']],
            ['name' => 'Docker',         'category' => 'DevOps & Cloud','proficiency_level' => 30, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['containers', 'virtualization']],
            ['name' => 'CI / CD',        'category' => 'DevOps & Cloud','proficiency_level' => 35, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['automation', 'pipelines']],
            ['name' => 'AWS',            'category' => 'DevOps & Cloud','proficiency_level' => 20, 'years_of_experience' => 0.3, 'is_featured' => false, 'tags' => ['cloud', 'infrastructure']],
            ['name' => 'cPanel / Shared Hosting', 'category' => 'DevOps & Cloud', 'proficiency_level' => 80, 'years_of_experience' => 4, 'is_featured' => false, 'tags' => ['hosting', 'deployment']],
            ['name' => 'XAMPP / LAMP',   'category' => 'DevOps & Cloud','proficiency_level' => 88, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['local dev', 'server stack']],

            // ── Cybersecurity ──
            ['name' => 'Web Security Basics', 'category' => 'Cybersecurity', 'proficiency_level' => 55, 'years_of_experience' => 2, 'is_featured' => false, 'tags' => ['OWASP', 'XSS', 'CSRF']],
            ['name' => 'Authentication & Authorization', 'category' => 'Cybersecurity', 'proficiency_level' => 75, 'years_of_experience' => 3, 'is_featured' => true, 'tags' => ['OAuth', 'JWT', 'Sanctum']],
            ['name' => 'SQL Injection Prevention', 'category' => 'Cybersecurity', 'proficiency_level' => 70, 'years_of_experience' => 3, 'is_featured' => false, 'tags' => ['parameterized', 'ORM']],
            ['name' => 'SSL / HTTPS',    'category' => 'Cybersecurity', 'proficiency_level' => 60, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['encryption', 'certificates']],
            ['name' => 'Network Basics', 'category' => 'Cybersecurity', 'proficiency_level' => 40, 'years_of_experience' => 1,   'is_featured' => false, 'tags' => ['TCP/IP', 'DNS', 'firewalls']],

            // ── Automation & Tooling ──
            ['name' => 'Task Automation','category' => 'Automation',    'proficiency_level' => 45, 'years_of_experience' => 1,   'is_featured' => false, 'tags' => ['scripting', 'cron']],
            ['name' => 'Web Scraping',   'category' => 'Automation',    'proficiency_level' => 40, 'years_of_experience' => 0.5, 'is_featured' => false, 'tags' => ['data extraction', 'crawling']],
            ['name' => 'Laravel Queues', 'category' => 'Automation',    'proficiency_level' => 65, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['jobs', 'background tasks']],
            ['name' => 'Scheduling (Cron)', 'category' => 'Automation', 'proficiency_level' => 70, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['scheduler', 'artisan']],

            // ── UI/UX Design ──
            ['name' => 'Figma',          'category' => 'Design',        'proficiency_level' => 35, 'years_of_experience' => 1,   'is_featured' => false, 'tags' => ['prototyping', 'wireframes']],
            ['name' => 'UI Design Principles', 'category' => 'Design', 'proficiency_level' => 65, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['layout', 'typography', 'color']],
            ['name' => 'UX Best Practices', 'category' => 'Design',    'proficiency_level' => 55, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['usability', 'accessibility']],

            // ── Document Editing ──
            ['name' => 'Microsoft Word',      'category' => 'Document Editing', 'proficiency_level' => 80, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['word processing', 'formatting']],
            ['name' => 'Microsoft Excel',     'category' => 'Document Editing', 'proficiency_level' => 70, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['spreadsheets', 'formulas']],
            ['name' => 'Microsoft PowerPoint','category' => 'Document Editing', 'proficiency_level' => 75, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['presentations', 'slides']],
            ['name' => 'Google Docs',         'category' => 'Document Editing', 'proficiency_level' => 78, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['cloud', 'collaboration']],
            ['name' => 'Google Sheets',       'category' => 'Document Editing', 'proficiency_level' => 65, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['cloud', 'data']],
            ['name' => 'PDF Editing',         'category' => 'Document Editing', 'proficiency_level' => 60, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['documents', 'forms']],

            // ── Hardware & Software Maintenance ──
            ['name' => 'PC Assembly & Repair',     'category' => 'Hardware & Software', 'proficiency_level' => 70, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['hardware', 'troubleshooting']],
            ['name' => 'OS Installation',          'category' => 'Hardware & Software', 'proficiency_level' => 85, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['Windows', 'Linux']],
            ['name' => 'Software Troubleshooting', 'category' => 'Hardware & Software', 'proficiency_level' => 80, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['debugging', 'diagnostics']],
            ['name' => 'Hardware Diagnostics',     'category' => 'Hardware & Software', 'proficiency_level' => 60, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['testing', 'components']],
            ['name' => 'Network Setup',            'category' => 'Hardware & Software', 'proficiency_level' => 55, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['LAN', 'WiFi', 'router']],
            ['name' => 'Printer & Peripherals',    'category' => 'Hardware & Software', 'proficiency_level' => 65, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['setup', 'drivers']],

            // ── Tools & Workflow ──
            ['name' => 'VS Code',        'category' => 'Tools',         'proficiency_level' => 90, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['IDE', 'extensions']],
            ['name' => 'Postman',        'category' => 'Tools',         'proficiency_level' => 78, 'years_of_experience' => 3,   'is_featured' => false, 'tags' => ['API testing', 'collections']],
            ['name' => 'Composer',       'category' => 'Tools',         'proficiency_level' => 82, 'years_of_experience' => 4,   'is_featured' => false, 'tags' => ['dependency manager', 'PHP']],
            ['name' => 'NPM / Vite',     'category' => 'Tools',         'proficiency_level' => 70, 'years_of_experience' => 2,   'is_featured' => false, 'tags' => ['bundler', 'package manager']],
            ['name' => 'phpMyAdmin',     'category' => 'Tools',         'proficiency_level' => 85, 'years_of_experience' => 5,   'is_featured' => false, 'tags' => ['database', 'GUI']],
        ];

        foreach ($skills as $skill) {
            Skill::create($skill);
        }

        // 4. Experiences
        Experience::create([
            'job_title' => 'Senior Developer',
            'company_name' => 'Innovate Tech',
            'company_location' => 'San Francisco, CA',
            'employment_type' => 'Full-time',
            'start_date' => '2021-06-01',
            'is_current' => true,
            'description' => 'Leading a team of 5 developers building enterprise SaaS products.',
            'achievements' => ['Reduced API response time by 40%', 'Led migration from legacy codebase to Laravel 10'],
            'technologies_used' => ['Laravel', 'Vue.js', 'AWS', 'Redis'],
            'display_order' => 1,
        ]);

        Experience::create([
            'job_title' => 'Web Developer',
            'company_name' => 'Creative Agency',
            'company_location' => 'Remote',
            'employment_type' => 'Full-time',
            'start_date' => '2019-01-01',
            'end_date' => '2021-05-31',
            'is_current' => false,
            'description' => 'Developed custom websites and e-commerce solutions for clients.',
            'achievements' => ['Delivered 20+ client projects', 'Implemented automated deployment pipeline'],
            'technologies_used' => ['PHP', 'WordPress', 'jQuery', 'MySQL'],
            'display_order' => 2,
        ]);

        // 5. Projects
        Project::create([
            'title' => 'E-commerce Platform',
            'description' => 'A multi-vendor e-commerce platform built with Laravel and React.',
            'project_type' => 'Professional',
            'technologies' => ['Laravel', 'React', 'Stripe', 'Elasticsearch'],
            'role' => 'Lead Developer',
            'start_date' => '2022-01-01',
            'is_ongoing' => true,
            'github_url' => 'https://github.com/example/ecommerce',
            'live_url' => 'https://example-ecommerce.com',
            'is_featured' => true,
            'highlights' => ['Handles 10k+ daily users', 'Real-time inventory sync'],
        ]);

        Project::create([
            'title' => 'Portfolio Generator',
            'description' => 'The very system currently running this site.',
            'project_type' => 'Personal',
            'technologies' => ['Laravel', 'Tailwind CSS', 'DomPDF'],
            'role' => 'Solo Developer',
            'start_date' => '2023-11-01',
            'is_ongoing' => true,
            'is_featured' => true,
        ]);

        // 6. Education
        Education::create([
            'institution_name' => 'Tech University',
            'degree' => 'Bachelor of Science',
            'field_of_study' => 'Computer Science',
            'location' => 'New York, NY',
            'start_date' => '2015-09-01',
            'end_date' => '2019-05-31',
            'grade' => '3.8 GPA',
            'description' => 'Specialized in Software Engineering and Database Systems.',
        ]);

        // 7. Certifications
        Certification::create([
            'name' => 'AWS Certified Solutions Architect',
            'issuing_organization' => 'Amazon Web Services',
            'issue_date' => '2023-01-15',
            'expiry_date' => '2026-01-15',
            'credential_id' => 'AWS-SEQ-12345',
        ]);

        // 8. Contact Info
        ContactInfo::create(['type' => 'email', 'value' => 'dev@portfolio.cms', 'display_name' => 'Email', 'is_primary' => true, 'display_order' => 1]);
        ContactInfo::create(['type' => 'phone', 'value' => '+1 (555) 123-4567', 'display_name' => 'Phone', 'display_order' => 2]);
        ContactInfo::create(['type' => 'linkedin', 'value' => 'https://linkedin.com/in/johndoe', 'display_name' => 'LinkedIn', 'display_order' => 3]);
        ContactInfo::create(['type' => 'github', 'value' => 'https://github.com/johndoe', 'display_name' => 'GitHub', 'display_order' => 4]);

        // 9. Resume Templates
        ResumeTemplate::create([
            'name' => 'Professional',
            'description' => 'A clean, traditional template suitable for corporate roles.',
            'layout_config' => [
                'sidebar' => false,
                'header_style' => 'centered',
                'sections_order' => ['summary', 'experience', 'skills', 'education', 'projects'],
            ],
            'styling_config' => [
                'primary_color' => '#2563eb', // Blue-600
                'font_family' => 'sans-serif',
            ],
            'thumbnail_url' => '/images/templates/professional.png',
        ]);

        ResumeTemplate::create([
            'name' => 'Modern Minimal',
            'description' => 'A sleek, minimalist design focusing on content.',
            'layout_config' => [
                'sidebar' => true,
                'header_style' => 'left-aligned',
                'sections_order' => ['skills', 'education', 'experience', 'projects'],
            ],
            'styling_config' => [
                'primary_color' => '#0f172a', // Slate-900
                'font_family' => 'serif',
            ],
            'thumbnail_url' => '/images/templates/minimal.png',
        ]);

        // Site Settings
        $this->call(SiteSettingsSeeder::class);
    }
}
