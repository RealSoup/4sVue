<template>

<form ref="form" @submit.prevent="write">
<div class="card">
    <div class="card-body">
        <div class="form-group">
            <label for="bo_subject">제목</label>
            <input type="text" class="form-control" name="bo_subject" id="bo_subject" v-model="frm.bo_subject">
            <div v-if="validationErrors.bo_subject !== undefined" class="alert alert-danger">
                {{ validationErrors.bo_subject }}
            </div>
        </div>
        <div class="form-group">
            <label for="bo_content">내용</label>
            <textarea class="form-control" name="bo_content" id="bo_content" rows="10" v-model="frm.bo_content" />
            <div v-if="validationErrors.bo_content !== undefined" class="alert alert-danger">
                {{ validationErrors.bo_content }}
            </div>
        </div>
        <div class="form-group">
            <label for="bo_file">첨부파일</label>
            <vue-dropzone ref="myVueDropzone" id="dropzone"
                :options="dropzoneOptions"
                v-on:vdropzone-success="dropzon_success"
                v-on:vdropzone-sending="dropzoneSending"
                v-on:vdropzone-error="dropzoneError">
            </vue-dropzone>
        </div>
    </div>

    <div class="card-footer">
        <div class="row">
            <div class="col-6">
                <router-link :to="{name: 'bo_index', params: { bo_cd:bo_cd }}" class="btn btn-sm btn-light">목록</router-link>
            </div>
            <div class="col-6 text-right">
                <button type="submit" class="btn btn-dark">게시글 작성</button>
            </div>
            {{this.$store.state.error.validationErrors}}
        </div>
    </div>
</div>
<template v-for="(fi_id, idx) in fi_ids">
    <input type="text" :name="'fi_id['+idx+']'" :value="fi_id" />
</template>

</form>

</template>
<script>
import * as boardApi from '@/api/board';
import { mapState } from 'vuex';

import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'

import { common } from "@/mixins/common"

export default {
    name: 'app',
    components: {
        vueDropzone: vue2Dropzone
    },
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            frm:{
                bo_subject: '',
                bo_content: ''
            },
            dropzoneOptions: {
                url: this.$store.state.board.bo_info.upload_path,
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                params: {'fi_type': 'board', 'fi_path': this.$route.params.bo_cd, is_thumb: this.$store.state.board.bo_info.is_thumb},
            },
            fi_ids: [],
        };
    },
    computed: {
        ...mapState('board', ['bo_info', 'loading']),
        ...mapState('error', {
            validationErrors: state => state.validations
        }),

    },
    methods: {
        write() {
            const data = this.getFormData("form");
            this.$store.dispatch('board/store', { bo_cd:this.bo_cd, frm:data });
        },

        dropzoneSending (file, xhr, formData) {
            // formData.append( "_token", document.head.querySelector('meta[name="csrf-token"]').content);
            // formData.append(fi_type:'board', fi_path: '12', is_thumb: '11');
        },
        dropzoneError(file, message, xhr){
            console.log(message);
        },
        dropzon_success(file, res) {
            this.fi_ids.push(res);
        },
    },
    mixins:[common],
    mounted() {
        this.$store.dispatch('board/initSet', "/api/board/"+this.bo_cd+"/create");
    },

}
</script>
