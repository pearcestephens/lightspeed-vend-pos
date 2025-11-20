import axios from 'axios';

const API_BASE = '/api/v1';

const client = axios.create({
    baseURL: API_BASE,
    timeout: 30000,
    headers: {
        'Content-Type': 'application/json',
    },
});

export const api = {
    get: (url: string, config?: any) => client.get(url, config),
    post: (url: string, data?: any, config?: any) => client.post(url, data, config),
    put: (url: string, data?: any, config?: any) => client.put(url, data, config),
    patch: (url: string, data?: any, config?: any) => client.patch(url, data, config),
    delete: (url: string, config?: any) => client.delete(url, config),
};

export default client;