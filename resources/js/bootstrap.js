import axios from 'axios';
window.axios = axios;

axios.defaults.baseURL = 'http://127.0.0.1:8000/api';
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
