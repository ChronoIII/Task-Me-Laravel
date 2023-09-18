import client from '@/client.js';

export default {
    async getArchivedTasks(oFilter) {
        let sParams = '?' + new URLSearchParams(oFilter);
        return await client.get('/archive' + sParams);
    },

    async archiveTask(iTaskId) {
        return await client.put('/archive/' + iTaskId);
    },

    async restoreTask(iArchivedTaskId) {
        return await client.delete('/archive/' + iArchivedTaskId);
    }
}
