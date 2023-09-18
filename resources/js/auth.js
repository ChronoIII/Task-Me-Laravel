import './bootstrap';

import { createApp } from 'vue';
import Auth from '@/components/auth/auth.vue';
import Router from '@/router.js';

const auth = createApp(Auth);

auth.use(Router);
auth.mount('#auth');
