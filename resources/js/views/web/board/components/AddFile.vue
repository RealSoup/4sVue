<template lang="html">
    <div class="form-group">
        <label for="bo_file">첨부파일</label>
        <vue-dropzone ref="myVueDropzone" id="dropzone"
            :options="dropzoneOptions"
            v-on:vdropzone-success="dropzon_success"
            v-on:vdropzone-sending="dropzoneSending"
            v-on:vdropzone-error="dropzoneError">
        </vue-dropzone>
    </div>
</template>

<script>
import vue2Dropzone from 'vue2-dropzone'
import 'vue2-dropzone/dist/vue2Dropzone.min.css'
export default {
    // props:['fi_id'],
    data() {
        return {
            fi_id:[],
            dropzoneOptions: {
                url: this.$store.state.board.bo_info.upload_path,
                headers: {
                    "X-CSRF-TOKEN": document.head.querySelector("[name=csrf-token]").content
                },
                params: {
                    'fi_type':  'board',
                    'fi_path':  this.$route.params.bo_cd,
                    'is_thumb': this.$store.state.board.bo_info.is_thumb
                },
            },
        };
    },
    components: {
        vueDropzone: vue2Dropzone
    },
    methods: {
        dropzoneSending (file, xhr, formData) {
            // formData.append( "_token", document.head.querySelector('meta[name="csrf-token"]').content);
            // formData.append(fi_type:'board', fi_path: '12', is_thumb: '11');
        },
        dropzoneError(file, message, xhr){
            console.log(message);
        },
        dropzon_success(file, res) {
            // this.frm.fi_id.push(res);
            this.$emit('passageFi_id', res);
        },
    },
}
</script>
