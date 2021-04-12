<template>
    <b-modal id="login-modal" centered :title="getTitle">
        <b-overlay :show="loading" rounded="sm">
        <b-form id="frm-login">
            <validation-provider
                name="이메일"
                :rules="{ required: true, email:true }"
                v-slot="validationContext">
            <b-form-group
                label="Email address:"
                label-for="email"
                description="가입이 등록한 Email">
                <b-form-input type="email" id="email" placeholder="Enter email"
                    v-model="user.email"
                    :state="getValidationState(validationContext)">
                </b-form-input>
                <b-form-invalid-feedback>{{ validationContext.errors[0] }}</b-form-invalid-feedback>
            </b-form-group>
            </validation-provider>

            <validation-provider
                name="패스워드"
                :rules="{ required:true, min:3 }"
                v-slot="validationContext">
                <b-form-group
                    label="Email password:"
                    label-for="password"
                    description="We'll never share your email with anyone else.">
                    <b-form-input type="password" id="password" placeholder="Enter password"
                        v-model="user.password"
                        :state="getValidationState(validationContext)">
                    </b-form-input>
                    <b-form-invalid-feedback>{{ validationContext.errors[0] }}</b-form-invalid-feedback>
                </b-form-group>
            </validation-provider>


        </b-form>
        </b-overlay>

        <template #modal-footer>
            <div class="w-100">
                <b-button variant="danger" class="float-left" @click="hideModal">취소</b-button>
                <b-button variant="primary" class="float-right" @click="login" >로그인</b-button>
            </div>
        </template>
    </b-modal>

</template>

<script>
import { mapActions, mapState, mapGetters } from 'vuex';

export default {
    name: "login",
    props: { // 부모 컴포넌트로부터 값 받는 옵션
        visible: {
            type: Boolean,
            require: true,
            default: true
        }, title: {
            type: String,
            require: false,
        },
    },
    data() {
        return {
            user:{
                email: 'kjk@4science.net',
                password: 'tkskdl38',
            },
            alertShow: false,
            loading: false,
            message: ''
            // show: true
        }
    },
    methods:{
        getValidationState({ dirty, validated, valid = null }) {
            return dirty || validated ? valid : null;
        },
        login() {
            this.$store.dispatch('auth/login', { email:this.user.email, password:this.user.password});
        },
        hideModal() {
            this.$bvModal.hide('login-modal')
        },

    },
    computed:{
        // user() {
        //     return this.$store.state.auth.user;
        // },
        getTitle(){
            return 'Login'
        },
        ...mapGetters({
            // getterAuth: 'auth/authGetter'
        }),
        // ...mapState({
        //     //  모듈이 아닐시
        //     stateAuth: 'auth'
        // }),
        ...mapState('auth', {
            stateAuth: 'auth'
        }),

    },
    mounted(){
    }




}
</script>
