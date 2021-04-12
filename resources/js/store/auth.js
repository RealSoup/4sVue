import * as authApi from '@/api/auth';

export default {
    namespaced: true,
    state: {
        user: {},
        is_auth: false
    },
    getters:{
        user: state => {
            return state.auth;
        },
        is_auth: state => {
            return state.is_auth;
        },
    },
    mutations: {
        setUser(state, data) {
            state.user = data.user;
            state.is_auth = data.is_auth;
        },

    },
    actions: {
        async login(context, {email, password}){
            try {
                const res = await authApi.login(email, password);
                if (res.status === 200) {
                    context.commit('setUser', {user:res.data, is_auth:true});
                }
            } catch (e) {
                alert(e.response.data.error);
            }
        },
        async logout(context){
            try {
                const res = await authApi.logout();
                if (res.status === 204) {
                    context.commit('setUser', {user:{}, is_auth:false});
                }
            } catch (e) {
                alert(e.response.data.error);
            }
        },
        check(context){
            if (window.auth_user !== null) {
                context.commit('setUser', {user:window.auth_user, is_auth:true});
            }
        },


    },
}
