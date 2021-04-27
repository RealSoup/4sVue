import * as boardApi from '@/api/board';
import router from '@/router';

export default {
    namespaced: true,
    state: {
        bo_info:{
            bo_cd:'',
            bo_nm:'',
            row:10,
            is_thumb:false,
            upload_path:'/api/upload',
        },
        loading: true,
        bo_data: {
            //  게시판 정보
            //  목록, 페이지네이션 정보, 게시판 코드, 게시판 명 등등
        },
        bo_con:{
            // 게시글 정보
            //  글제목, 글내용 등등
        },
        bo_comment:{ // 게시글 댓글
        },
        bo_frm: {
            //  글작성시 제목, 글내용, 첨부파일 ID 등등...
        },
    },
    getters:{
        // data: state => {
        //     return state.data;
        // },
        // loading: state => {
        //     return state.loading;
        // },
        // setUploatUrl:state => {
        //     return state.loading;
        // },
    },
    mutations: {
        commonSet(state, data) {
            state.bo_info.bo_cd         = data.bo_cd;
            state.bo_info.bo_nm         = data.bo_nm;
            state.bo_info.row           = data.row;
            state.bo_info.is_thumb      = data.is_thumb;
            state.bo_info.is_addFile      = data.is_addFile;
            state.bo_info.is_comment      = data.is_comment;
        },
        index(state, data) {
            state.loading  = false;
            state.bo_data  = data.board;
        },
        show(state, data) {
            state.loading         = false;
            state.bo_con          = data.bo;
            state.bo_con.add_file = data.add_file;
            state.bo_con.img_file = data.img_file;
            state.bo_comment      = data.comment;
        },
        form(state, data) {
            state.bo_frm = data;
        },

    },
    actions: {
        async initSet(context, url){
            try {
                const res = await boardApi.initSet(url);
                if (res.status === 200) {
                    context.commit('commonSet', res.data);
                }
            } catch (e) {
                alert(e.res.data.error);
            }
        },
        async index(context, payload){
            try {
                const res = await boardApi.index(payload.bo_cd, payload.qryString);
                if (res.status === 200) {
                    context.commit('commonSet', res.data);
                    context.commit('index', res.data);
                }
            } catch (e) {
                alert(e.res.data.error);
            }
        },
        async show(context, payload){
            try {
                const res = await boardApi.show(payload.bo_cd, payload.bo_id);
                if (res.status === 200) {
                    context.commit('commonSet', res.data);
                    context.commit('show', res.data);
                }
            } catch (e) {
                alert(e.res.data.error);
            }
        },
        async store(context, payload){
            try{
                const res = await boardApi.store(payload.bo_cd, payload.frm);

                if ( res ) {
                    if ( res.status === 200) {
                        router.push({ name: 'bo_index', params: { bo_cd: payload.bo_cd }})
                    } else if ( res.status === 422) {
                        // console.log(res.data);
                    }
                }
            } catch (e) {
                console.log(e);
                alert(e.res.data.error);
            }
        },


        // async logout(context){
        //     try {
        //         const res = await authApi.logout();
        //         if (res.status === 204) {
        //             context.commit('setUser', {user:{}, is_auth:false});
        //         }
        //     } catch (e) {
        //         alert(e.res.data.error);
        //     }
        // },
        // check(context){
        //     if (window.auth_user !== null) {
        //         context.commit('setUser', {user:window.auth_user, is_auth:true});
        //     }
        // },


    },
}
