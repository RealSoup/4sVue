import http from './http';


export function initSet(url) { return http.get(url); }

export function store(bo_cd, frm) {
    return http.post('/api/board/'+bo_cd+'/store', frm);
}

export function index(bo_cd) {
    return http.get('/api/board/'+bo_cd);
}
