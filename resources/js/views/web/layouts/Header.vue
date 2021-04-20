<template>
<div class="container">
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="/">NavBar</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <ul class="navbar-nav mr-auto">
                <b-nav-item :to="{name: 'pic01'}" active-class="active" exact>이런페이지</b-nav-item>
                <b-nav-item :to="{name: 'pic02'}" active-class="active" exact>저런페이지</b-nav-item>
            </ul>
            <b-navbar-nav class="">
                <b-nav-item-dropdown>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em>게시판</em>
                    </template>
                    <b-dropdown-item :to="{name: 'bo_index', params: { bo_cd:'normal' }}">일반게시판</b-dropdown-item>
                    <b-dropdown-item :to="{name: 'bo_index', params: { bo_cd:'photo' }}">포토 게시판</b-dropdown-item>
                </b-nav-item-dropdown>
                <b-nav-item  active-class="active" exact>게시판</b-nav-item>
                <b-nav-item href="#" disabled>Disabled</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-item v-if="is_auth">{{user.name}}</b-nav-item>
                <b-nav-item-dropdown right v-if="is_auth">
                
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em>User</em>
                    </template>
                    <b-dropdown-item href="#">Profile</b-dropdown-item>
                    <b-dropdown-item @click="logout">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>

                <b-navbar-nav v-else>
                    <b-button variant="info" @click="loginView">Login</b-button>
                    <login-pop-up></login-pop-up>
                </b-navbar-nav>


                <b-nav-form>
                    <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>
            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</div>
</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';
import LoginPopUp from '../auth/Login'
import * as authApi from '@/api/auth';
export default {
    name: 'Header',
    data() {
        return {
            // is_auth: this.$store.state.auth.is_auth,
        }
    },
    components: { LoginPopUp },
    computed: {
        // ...mapState('auth', {
        //     user: state => $store.state.user,
        //     is_auth: state => $store.state.is_auth,
        // }),
        // ...mapGetters('is_auth'),
        ...mapState('auth', ['is_auth', 'user']),
        ...mapState('board', ['dd', 'bo_cd']),
    },
    methods:{
        loginView(){
            this.$bvModal.show('login-modal')
        },

        logout() {
            this.$store.dispatch('auth/logout');
        },
    },

    mounted(){
        // this.loginView()
    }
}
</script>

<style>

</style>
