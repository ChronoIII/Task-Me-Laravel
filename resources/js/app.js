import './bootstrap';
import '@vuepic/vue-datepicker/dist/main.css';

import { createApp } from 'vue';
import Dashboard from './components/dashboard/dashboard.vue';
import Store from './store.js';
import Router from './router.js';

const app = createApp(Dashboard);

app.use(Store);
app.use(Router);
app.mount('#app');
