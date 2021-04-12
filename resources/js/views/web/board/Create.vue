<template>
  <div class="card">
    <div class="card-body">
      <div class="form-group">
        <label for="bo_subject">제목</label>
        <input type="text" class="form-control" id="bo_subject" v-model="bo_subject">
        <div v-if="validationErrors.bo_subject !== undefined" class="alert alert-danger">
          {{ validationErrors.bo_subject }}
        </div>
      </div>
      <div class="form-group">
        <label for="bo_content">내용</label>
        <textarea class="form-control" id="bo_content" rows="10" v-model="bo_content" />
        <div v-if="validationErrors.bo_content !== undefined" class="alert alert-danger">
          {{ validationErrors.bo_content }}
        </div>
      </div>
    </div>
    <div class="card-footer text-right">
      <button type="button" class="btn btn-dark" @click="write">
        게시글 작성
      </button
      {{this.$store.state.error.validationErrors}}>
    </div>
  </div>
</template>
<script>
import * as boardApi from '@/api/board';
import { mapState } from 'vuex';
export default {
    data() {
      return {
        bo_subject: '',
        bo_content: ''
      };
    },
    computed: {
        ...mapState('error', {
            validationErrors: state => state.validations
        })
    },
    methods: {
      write() {
        boardApi.store(this.bo_subject, this.bo_content).then(response => {
          console.log(response);
        }).catch(error => {
          console.log(error);
        })
      }
    }
}
</script>
