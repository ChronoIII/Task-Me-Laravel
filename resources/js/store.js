import { createStore } from 'vuex';
import Task from './stores/task';
import Archive from './stores/archive';

export default createStore({
    modules: [
        Task,
        Archive,
    ],
});
