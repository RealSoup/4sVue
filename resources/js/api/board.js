import http from './http';


export function initSet(url) { return http.get(url); }

export function index(bo_cd, qryString) {
    return http.get('/api/board/'+bo_cd+'?' + qryString);
}

export function show(bo_cd, bo_id) {
    return http.get('/api/board/'+bo_cd+'/show/' + bo_id);
}

export function store(bo_cd, frm) {
    return http.post('/api/board/'+bo_cd+'/store', frm);
}
