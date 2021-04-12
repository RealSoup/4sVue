<template>
<header id="header" class="container">
    <b-navbar toggleable="lg" type="dark" variant="info">
        <b-navbar-brand href="/">NavBar</b-navbar-brand>

        <b-navbar-toggle target="nav-collapse"></b-navbar-toggle>

        <b-collapse id="nav-collapse" is-nav>
            <b-navbar-nav>
                <b-nav-item href="/pic01">이런페이지</b-nav-item>
                <b-nav-item href="/pic02">저런페이지</b-nav-item>
                <b-nav-item href="/board/normal">게시판</b-nav-item>
                <b-nav-item href="/board/normal/create">게시판 글쓰기</b-nav-item>
                <b-nav-item href="#" disabled>Disabled</b-nav-item>
            </b-navbar-nav>

            <!-- Right aligned nav items -->
            <b-navbar-nav class="ml-auto">
                <b-nav-form>
                    <b-form-input size="sm" class="mr-sm-2" placeholder="Search"></b-form-input>
                    <b-button size="sm" class="my-2 my-sm-0" type="submit">Search</b-button>
                </b-nav-form>

                <b-nav-item-dropdown text="Lang" right>
                    <b-dropdown-item href="#">EN</b-dropdown-item>
                    <b-dropdown-item href="#">ES</b-dropdown-item>
                    <b-dropdown-item href="#">RU</b-dropdown-item>
                    <b-dropdown-item href="#">FA</b-dropdown-item>
                </b-nav-item-dropdown>

                <b-nav-item-dropdown right>
                    <!-- Using 'button-content' slot -->
                    <template #button-content>
                        <em>User</em>
                    </template>
                    <b-dropdown-item href="#">Profile</b-dropdown-item>
                    <b-dropdown-item href="#">Sign Out</b-dropdown-item>
                </b-nav-item-dropdown>



                <b-nav-item-dropdown right>
                <!--@guest
                    @if (Route::has('login'))
                        <a href="/login">Login</a>
                    @endif

                    @if (Route::has('register'))
                        <a href="/register">Register</a>
                    @endif
                @else
                <a href="/mypage"><i class="bi bi-reception-4"></i>{{$user.level}} {{ user.name }} </a>
                <a href="/logout"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Logout'
                </a>
                <form id="logout-form" action="/logout" method="POST" class="d-none">@csrf</form>

                @endguest-->
                </b-nav-item-dropdown>




                <b-navbar-nav v-if="is_auth">
                    <b-button variant="info" @click="logout">LogOut</b-button>
                </b-navbar-nav>
                <b-navbar-nav v-else>
                    <b-button variant="info" @click="loginView">Login</b-button>
                    <login-pop-up></login-pop-up>
                </b-navbar-nav>


            </b-navbar-nav>
        </b-collapse>
    </b-navbar>
</header>
</template>

<script>
import { mapState, mapGetters, mapActions} from 'vuex'
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
        ...mapGetters(['is_auth']),
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
