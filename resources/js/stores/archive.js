import ArchiveService from '@/services/ArchiveService.js';

export default {
    state: {
        archives: {
            data: [],
            current_page: 1,
            last_page: 1,
            per_page: 10,
            total: 0,
        },
        filter: {
            count: 10,
            page: 1,
        }
    },

    mutations: {
        SET_ARCHIVE_LIST(state, oList) {
            state.archives = oList;
        },
        SET_ARCHIVE_FILTER(state, aFilterUpdate) {
            let aCopyFilter = {...state.filter};
            aCopyFilter[aFilterUpdate['key']] = aFilterUpdate['value'];
            state.filter = aCopyFilter;
        },

        ASSIGN_ARCHIVE_FILTER(state, oFilter) {
            state.filter = oFilter;
        }
    },

    actions: {
        async getArchivedTasks({ state, commit }) {
            return await ArchiveService.getArchivedTasks(state.filter)
                .then(res => {
                    let oData = res.data;
                    commit('SET_ARCHIVE_LIST', oData);
                    return oData;
                });
        },

        async archiveTask({ dispatch }, iTaskId) {
            return await ArchiveService.archiveTask(iTaskId)
                .then(res => {
                    dispatch('getArchivedTasks');
                    return res.data;
                });
        },

        async restoreTask({ dispatch }, iTaskId) {
            return await ArchiveService.restoreTask(iTaskId)
                .then(res => {
                    dispatch('getArchivedTasks');
                    return res.data;
                });
        }
    },

    getters: {
        archives(state) {
            return state.archives.data;
        },
        archiveCurrentPage(state) {
            return state.archives.current_page;
        },
        archivePageCount(state) {
            return state.archives.per_page;
        },
        archiveLastPage(state) {
            return state.archives.last_page;
        }
    }
}
