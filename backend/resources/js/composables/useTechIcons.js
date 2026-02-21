import { ref } from 'vue';

/**
 * Maps skill names → Simple Icons slugs + brand hex colors.
 * CDN: https://cdn.simpleicons.org/{slug}/{color}
 */
const techIconMap = {
  // Backend
  'PHP':            { s: 'php',            c: '777BB4' },
  'Laravel':        { s: 'laravel',        c: 'FF2D20' },
  'Node.js':        { s: 'nodedotjs',      c: '5FA04E' },
  'Python':         { s: 'python',         c: '3776AB' },
  'Livewire':       { s: 'livewire',       c: '4E56A6' },

  // Frontend
  'HTML5':          { s: 'html5',          c: 'E34F26' },
  'CSS3':           { s: 'css3',           c: '1572B6' },
  'Tailwind CSS':   { s: 'tailwindcss',    c: '06B6D4' },
  'Bootstrap':      { s: 'bootstrap',      c: '7952B3' },
  'JavaScript':     { s: 'javascript',     c: 'F7DF1E' },
  'Vue.js':         { s: 'vuedotjs',       c: '4FC08D' },
  'Alpine.js':      { s: 'alpinedotjs',    c: '8BC0D0' },
  'React':          { s: 'react',          c: '61DAFB' },
  'SASS / SCSS':    { s: 'sass',           c: 'CC6699' },

  // Database
  'MySQL':          { s: 'mysql',          c: '4479A1' },
  'PostgreSQL':     { s: 'postgresql',     c: '4169E1' },
  'SQLite':         { s: 'sqlite',         c: '003B57' },
  'Redis':          { s: 'redis',          c: 'FF4438' },
  'MongoDB':        { s: 'mongodb',        c: '47A248' },

  // AI & ML
  'ChatGPT / Claude': { s: 'openai',      c: '412991' },

  // DevOps & Cloud
  'Git / GitHub':   { s: 'git',            c: 'F05032' },
  'Linux / CLI':    { s: 'linux',          c: 'FCC624' },
  'Docker':         { s: 'docker',         c: '2496ED' },
  'AWS':            { s: 'amazonaws',      c: 'FF9900' },
  'cPanel / Shared Hosting': { s: 'cpanel', c: 'FF6C2C' },
  'XAMPP / LAMP':   { s: 'xampp',          c: 'FB7A24' },

  // Document Editing
  'Microsoft Word':       { s: 'microsoftword',       c: '2B579A' },
  'Microsoft Excel':      { s: 'microsoftexcel',      c: '217346' },
  'Microsoft PowerPoint': { s: 'microsoftpowerpoint', c: 'B7472A' },
  'Google Docs':          { s: 'googledocs',           c: '4285F4' },
  'Google Sheets':        { s: 'googlesheets',         c: '34A853' },

  // Design
  'Figma':          { s: 'figma',          c: 'F24E1E' },

  // Tools
  'VS Code':        { s: 'visualstudiocode', c: '007ACC' },
  'Postman':        { s: 'postman',        c: 'FF6C37' },
  'Composer':       { s: 'composer',       c: '885630' },
  'NPM / Vite':     { s: 'npm',           c: 'CB3837' },
  'phpMyAdmin':     { s: 'phpmyadmin',     c: '6C78AF' },
};

export function useTechIcons() {
  const failedIcons = ref(new Set());

  const getIconUrl = (name) => {
    const icon = techIconMap[name];
    return icon ? `https://cdn.simpleicons.org/${icon.s}/${icon.c}` : null;
  };

  const hasIcon = (name) => !!techIconMap[name] && !failedIcons.value.has(name);

  const onIconError = (name, event) => {
    if (event?.target) event.target.style.display = 'none';
    failedIcons.value = new Set([...failedIcons.value, name]);
  };

  return { getIconUrl, hasIcon, onIconError };
}
