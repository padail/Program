import './bootstrap';

import { createApp, h } from 'vue'
import { createInertiaApp, Link, Head } from '@inertiajs/vue3'
// Vuetify
import 'vuetify/styles'
import 'material-design-icons-iconfont/dist/material-design-icons.css'
import '@mdi/font/css/materialdesignicons.css'
import { createVuetify } from 'vuetify'
import { aliases, md } from 'vuetify/iconsets/md'
import { mdi } from 'vuetify/iconsets/mdi'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
const vuetify = createVuetify({
    components,
    directives,
    icons: {
        defaultSet: 'md',
        aliases,
        sets: {
        md,
        sets: {
            mdi,
          },
        },
      },
   })

createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    createApp({ render: () => h(App, props) })
      .component('Link', Link)
      .component('Head', Head)
      .use(plugin)
      .use(vuetify)
      .mount(el)
  },
})
