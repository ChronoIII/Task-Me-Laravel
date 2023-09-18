import { createRouter, createWebHistory } from 'vue-router';

import LoginForm from '@/components/auth/forms/loginForm.vue';
import RegisterForm from '@/components/auth/forms/registerForm.vue';
import TaskListForm from '@/components/dashboard/tasks/taskList.vue';
import TaskViewForm from '@/components/dashboard/tasks/taskPage.vue';
import ArchiveListForm from '@/components/dashboard/tasks/taskArchive.vue';

const routes = [
    {
        path: '/login',
        name: 'Login',
        component: LoginForm,
    },
    {
        path: '/register',
        name: 'Register',
        component: RegisterForm,
    },
    {
        path: '/tasks',
        name: 'Tasks',
        component: TaskListForm,
        meta: {
            breadcrumbs: ['Home', 'Tasks']
        }
    },
    {
        path: '/task/:id',
        name: 'Task',
        component: TaskViewForm,
        meta: {
            breadcrumbs: ['Home', 'Tasks', 'View Task']
        }
    },
    {
        path: '/archives',
        name: 'Archives',
        component: ArchiveListForm,
        meta: {
            breadcrumbs: ['Home', 'Archives']
        }
    },
];

export default createRouter({
    routes,
    history: createWebHistory(),
});
