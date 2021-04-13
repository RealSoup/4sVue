<template>
    <div class="lists">
        <div class="loading text-center p-5" v-if="loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>

        <div v-if="error" class="error">
            {{ error }}
            <button @click.prevent="fetchData"> Try Again </button>
        </div>

        <table class="table table-striped table-hover" v-if="data">
            <colgroup>
            <col width="10%" />
            <col width="" />
            <col width="15%" />
            <col width="10%" />
            </colgroup>
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">제목</th>
                <th scope="col">작성자</th>
                <th scope="col">작성일</th>
            </tr>
            </thead>
            <tbody>
                <tr v-for="(row, idx) in data" :key="idx">
                    <th scope="row">{{idx}}</th>
                    <td>
                        <a :href="'/board/'+bo_cd+'/view/'+row.bo_id">{{row.bo_subject}}</a>
                    </td>
                    <td>{{row.bo_writer}}</td>
                    <td>{{row.bo_date}}</td>
                </tr>
            </tbody>
        </table>

    </div>
</template>
<script>
import * as boardApi from '@/api/board';
import { mapState } from 'vuex';
export default {
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            error: null,
        };
    },
    // created() {
    //     this.fetchData();
    // },
    computed: {
        ...mapState('board', ['data', 'loading']),


    },
    methods: {
        index() {
            this.$store.dispatch('board/index', { bo_cd:this.$route.params.bo_cd });
        },
        dateForm(date) {
            return comApi.dateForm(date);
        },

            // axios
            //     .get('/api/board/normal')
            //     .then(response => {
            //         this.loading = false;
            //         this.lists = response.data.data;
            //         console.log(response.data);
            //     }).catch(error => {
            //         this.loading = false;
            //         this.error = error.response.data.message || error.message;
            //         console.log(456);
            //     });

    },
    mounted() {
        this.index();
    },
}
</script>
