<template>
<div class="">
    <div class="form-group">
        <label for="bo_subject">제목</label>
        <input type="text" class="form-control" name="bo_subject" id="bo_subject" ref="bo_subject"
            v-model="bo_subject"
            @input="updateValue" />
        <div v-if="validationErrors.bo_subject !== undefined" class="alert alert-danger">
            {{ validationErrors.bo_subject }}
        </div>
    </div>
    <div class="form-group">
        <label for="bo_content">내용</label>
        <textarea class="form-control" name="bo_content" id="bo_content" ref="bo_content" rows="10"
            v-model="bo_content"
            @input="updateValue" />
        <div v-if="validationErrors.bo_content !== undefined" class="alert alert-danger">
            {{ validationErrors.bo_content }}
        </div>
    </div>

    <AddFile
        v-if="bo_info.is_addFile"
        :fi_id='fi_id'
        @passageFi_id="pushFi_id"
    />

</div>
</template>

<script>
import { mapState } from 'vuex';

import AddFile from "./components/AddFile.vue"
import Comment from "./components/Comment.vue"

export default {
    name: 'FormGroup',
    components: {
        AddFile,
        Comment,
    },
    data() {
        return {
            bo_subject: '123',
            bo_content: '456',
            fi_id:[],
        };
    },
    computed: {
        ...mapState('board', ['bo_info', 'loading']),
        ...mapState('error', {
            validationErrors: state => state.validations
        }),

    },
    methods: {
        updateValue() {
            this.$emit("input", {
                bo_subject: this.$refs.bo_subject.value,
                bo_content: this.$refs.bo_content.value,
                fi_id: this.fi_id,
            });
        },
        pushFi_id(fi_id) {
            this.fi_id.push(fi_id);
            this.updateValue();
        },
    },

}
</script>
