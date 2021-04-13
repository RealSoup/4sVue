import http from './http';


export async function store(bo_subject, bo_content) {
    const res = await http.post('/api/board/normal/store', {
        bo_subject,
        bo_content
    });
    if (response.status === 200){
        console.log(res);
    }
}


export function index(bo_cd) {
    return http.get('/api/board/'+bo_cd);
}
