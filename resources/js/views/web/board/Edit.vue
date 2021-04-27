<template>
<div class="board">
    <div id="bo_show" class="container">
         <h3>{{bo_con.bo_subject}}</h3>
    </div>
    <form ref="form" @submit.prevent="write">

        <FormGroup v-model="frm" />

        <div class="row">
            <div class="col-6">
                <router-link :to="{name: 'bo_index', params: { bo_cd:bo_cd }}" class="btn btn-sm btn-light">목록</router-link>
            </div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-dark">게시글 작성</button>
            </div>
        </div>

        <template v-for="(id, idx) in frm.fi_id">
            <input type="hidden" :name="'fi_id['+idx+']'" :value="id" />
        </template>
    </form>

</div>
</template>
<script>
import * as boardApi from '@/api/board';
import { mapState } from 'vuex';

import { common } from "@/mixins/common"

import FormGroup from './FormGroup.vue';

export default {
    name: 'edit',
    components: {
        FormGroup,
    },
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            frm:{
                bo_subject: '123',
                bo_content: '456',
                fi_id:[]
            },
            dropzoneOptions: {
                url: this.$store.state.board.bo_info.upload_path,
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                params: {'fi_type': 'board', 'fi_path': this.$route.params.bo_cd, is_thumb: this.$store.state.board.bo_info.is_thumb},
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
