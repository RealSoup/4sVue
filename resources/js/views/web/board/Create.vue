<template>

<form ref="form" @submit.prevent="write">

    <FormGroup
        v-model="frm"
    />
<!--
v-model="something"

:value="something"
@input="value => { something = value }"
-->
    <div class="row">
        <div class="col-6">
            <router-link :to="{name: 'bo_index', params: { bo_cd:bo_cd }}" class="btn btn-sm btn-light">목록</router-link>
        </div>
        <div class="col-6 text-right">
            <button type="submit" class="btn btn-dark">게시글 작성</button>
        </div>
        {{this.$store.state.error.validationErrors}}
    </div>
</form>

</template>
<script>
import * as boardApi from '@/api/board';
import { mapState } from 'vuex';

import FormGroup from "./FormGroup.vue";

import { common } from "@/mixins/common";

export default {
    name: 'create',
    components: {
        FormGroup,
    },
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            frm: {
                bo_subject:'',
                bo_content:'',
                fi_id:[],
            },
        };
    },
    computed: {
        ...mapState('board', ['bo_info', 'loading']),
    },
    methods: {
        write() {
            // const data = this.getFormData("form");
            this.$store.dispatch('board/store', { bo_cd:this.bo_cd, frm:this.frm });
        },
    },
    mixins:[common],
    mounted() {
        this.$store.dispatch('board/initSet', "/api/board/"+this.bo_cd+"/create");
    },

}
</script>
