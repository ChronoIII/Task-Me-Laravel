import client from '@/client.js';

export default {
    async getTasks(oFilter) {
        let sParams = '?' + new URLSearchParams(oFilter);
        return await client.get('/task' + sParams);
    },

    async getTask(iTaskId) {
        return await client.get('/task/' + iTaskId);
    },

    async saveTask(oTask) {
        return await client.post('/task', oTask, {
            'Content-Type': 'multipart/form-data'
        });
    },
}
