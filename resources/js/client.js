import axios from 'axios';

const adminClient = axios.create({
    baseURL: '/admin/api',
})

adminClient.interceptors.response.use(
    response => {
        return response;
    },

    error => {
        if (error.response.status === 401) {
            alert('Session expired. Please login again.');
            window.location.replace('/login');
        }
        return Promise.reject(error);
    }
);

export default adminClient;
