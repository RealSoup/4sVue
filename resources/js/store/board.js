import * as boardApi from '@/api/board';
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

        list: {},
        loading: true,


    },
    getters:{
        data: state => {
            return state.data;
        },
        loading: state => {
            return state.loading;
        },
        setUploatUrl:state => {
            return state.loading;
        },
    },
    mutations: {
        setData(state, data) {
            state.data = data.data;
            state.loading = false;
        },
        initSet(state, data) {
            state.bo_info.bo_cd         = data.bo_cd;
            state.bo_info.bo_nm         = data.bo_nm;
            state.bo_info.row           = data.row;
            state.bo_info.is_thumb      = data.is_thumb;
            // state.bo_info.upload_path   = data.upload_path;
        },

    },
    actions: {
        async initSet(context, url){
            try {
                const res = await boardApi.initSet(url);
                if (res.status === 200) {
                    context.commit('initSet', res.data);
                }
            } catch (e) {
                alert(e.res.data.error);
            }
        },

        async index(context, {bo_cd}){
            try {
                const res = await boardApi.index(bo_cd);
                if (res.status === 200) {
                    console.log(res.data);
                    context.commit('setData', {data:res.data});
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
                        console.log(res.data);
                    } else if ( res.status === 422) {
                        console.log(res.data);
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
