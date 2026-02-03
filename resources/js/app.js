import './bootstrap'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers'
import Layout from './Shared/Layout.vue'
import { InertiaProgress } from '@inertiajs/progress'
import { ZiggyVue } from 'ziggy-js'

const appName =
    window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel'

createInertiaApp({
    title: title => `${title} - ${appName}`,

    resolve: name => {
        const page = resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue')
        )

        page.then(module => {
            module.default.layout ??= Layout
        })

        return page
    },

    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, window.Ziggy)
            .mount(el)
    },
})

InertiaProgress.init()
