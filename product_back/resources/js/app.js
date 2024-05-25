import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp , Head, Link} from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';
const r = (url,data) =>{
    const ret = [];
    for (let d in data)
      ret.push(encodeURIComponent(d) + '=' + encodeURIComponent(data[d]));
    return url+'?'+ ret.join('&');
 }

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
       
      

        if (parseInt(App.version) > 2) {
            App.provide('route', r);
        }
        return createApp({ render: () => h(App, props) })
  
            .use(plugin)
            // .mixin({methods: {
            //     route: r,
            //     }})
            // .provide('route', r)
            .component('IHead', Head)
            .component('ILink', Link)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});