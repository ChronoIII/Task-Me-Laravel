import TaskService from '@/services/TaskService.js';

export default {
    state: {
        tasks: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        filter: {
            count: 10,
            page: 1,
        },
    },

    mutations: {
        SET_TASK_LIST(state, oList) {
            state.tasks = oList;
        },

        SET_TASK_FILTER(state, { key, value }) {
            let oFilter = {...state.filter};
            oFilter[key] = value;
            state.filter = oFilter;
        },

        ASSIGN_TASK_FILTER(state, oFilter) {
            state.filter = oFilter;
        }
    },

    actions: {
        async getTasks({ state, commit }) {
            return await TaskService.getTasks(state.filter)
                .then(res => {
                    let oData = res.data;
                    commit('SET_TASK_LIST', oData);
                    return oData;
                });
        },

        async getTask({}, iTaskId) {
            return await TaskService.getTask(iTaskId)
                .then(res => {
                    return res.data;
                });
        },

        async saveTask({ dispatch }, oTaskData) {
            let oFormData = new FormData();
            let aKeys = Object.keys(oTaskData);
            aKeys.forEach(sKey => {
                if (sKey === 'files' && oTaskData['files'].length > 0) {
                    for (let i = 0; i < oTaskData['files'].length; i++) {
                        oFormData.append(sKey + '[' + i +']', oTaskData['files'][i]);
                    }
                    return;
                }
                oFormData.append(sKey, oTaskData[sKey] ?? '');
            });

            return await TaskService.saveTask(oFormData)
                .then(res => {
                    dispatch('getTasks');
                    return res.data;
                });
        },
    },

    getters: {
        tasks(state) {
            return state.tasks.data;
        },

        taskFilter(state) {
            return state.filter;
        },

        taskCurrentPage(state) {
            return state.tasks.current_page;
        },

        taskLastPage(state) {
            return state.tasks.last_page;
        },

        taskPageCount(state) {
            return state.tasks.per_page;
        },

        totalCount(state) {
            return state.tasks.total;
        }
    }
}
