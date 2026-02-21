import '../css/app.css';
import 'nprogress/nprogress.css';

import { createApp, h } from 'vue';
import { createInertiaApp, router } from '@inertiajs/vue3';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import NProgress from 'nprogress';

// Page loading indicator
NProgress.configure({ showSpinner: false });
router.on('start', () => NProgress.start());
router.on('finish', () => NProgress.done());

const appName = 'jaykod.io';

createInertiaApp({
    title: (title) => {
        return title ? `${title} — ${appName}` : appName;
    },
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: false,
});