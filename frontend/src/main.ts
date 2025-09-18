import './assets/main.css'
import 'primeicons/primeicons.css';

import { createApp }   from 'vue';
import { createPinia } from 'pinia';

import App          from './App.vue';
import router       from './router';
import PrimeVue     from 'primevue/config';
import Aura         from '@primeuix/themes/aura';
import ToastService from 'primevue/toastservice';
import Toast        from 'primevue/toast';
import Loader       from '@/components/Layout/Loader.vue';

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.use(PrimeVue, {
    theme: {
        preset: Aura
    },
    options: {
        darkModeSelector: false
    }
});

app.use(ToastService);

app.component('Toast' , Toast);
app.component('Loader', Loader);

app.mount('#app')
