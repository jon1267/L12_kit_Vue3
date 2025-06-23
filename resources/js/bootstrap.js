// Этот код: чтоб аксиос был виден на протяжении всего проета
// и позволяет использовать CSRF-токен в запросах Axios
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';