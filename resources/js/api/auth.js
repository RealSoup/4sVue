import http from './http';
import store from '@/store';

export function login(email, password) {
    return http.post('/login', { email, password });
}

export function logout(email, password) {
    return http.post('/logout');
}

export async function show() {
    return http.get('/api/user');
}


// $http.get('api/user').then(response => {
//    console.log(response.body);
// })
