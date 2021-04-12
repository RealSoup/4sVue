import axios from 'axios';
import store from '@/store';

const instance = axios.create({
    baseURL: process.env.MIX_APP_URL,
    // headers: {
    //     // 'Accept' : 'application/json',
    //     // 'Content-Type' : 'application/json',
    //     'X-Requested-With': 'XMLHttpRequest',
    //     'X-CSRF-TOKEN' : document.head.querySelector('meta[name="csrf-token"]').content,
    // }
});

//  라라벨 Passport 기능으로 토큰 문제 처리함
// instance.interceptors.request.use(function (config) {
//     if (store.state.auth.user !== null && store.state.auth.user.api_token !== null) {
//         config['headers'] = {
//             Authorization: `Bearer ${store.state.auth.token}`
//         };
//     }
//
//     return config;
// });

/*instance.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response.status !== 419) return Promise.reject(error)
    window.location.reload()
  }
)*/
instance.interceptors.response.use(function (response) {
    store.commit('error/setValidationError', {});

    return response;
}, function (error) {
    if (error.response.status === 422) {
        store.commit('error/setValidationError', error.response.data.errors);
    } else {
        return Promise.reject(error);
    }
});

export default instance;
