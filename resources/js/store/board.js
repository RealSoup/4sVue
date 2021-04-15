import * as boardApi from '@/api/board';
export default {
    namespaced: true,
    state: {
        list: {},
        loading: true
    },
    getters:{
        data: state => {
            return state.data;
        },
        loading: state => {
            return state.loading;
        },
    },
    mutations: {
        setData(state, data) {
            state.data = data.data;
            state.loading = false;
        },

    },
    actions: {

        async index(context, {bo_cd}){
            try {
                const res = await boardApi.index(bo_cd);
                if (res.status === 200) {
                    console.log(res.data);
                    context.commit('setData', {data:res.data});
                }
            } catch (e) {
                alert(e.response.data.error);
            }
        },
        // async logout(context){
        //     try {
        //         const res = await authApi.logout();
        //         if (res.status === 204) {
        //             context.commit('setUser', {user:{}, is_auth:false});
        //         }
        //     } catch (e) {
        //         alert(e.response.data.error);
        //     }
        // },
        // check(context){
        //     if (window.auth_user !== null) {
        //         context.commit('setUser', {user:window.auth_user, is_auth:true});
        //     }
        // },


    },
}
