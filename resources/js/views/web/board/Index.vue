<template>
    <div class="bo_index">
        <h2>{{bo_info.bo_nm}}</h2>
        <div class="loading text-center p-5" v-if="loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>

        <div v-if="error" class="error">
            {{ error }}

        </div>

        <div class="row mb-2">
            <div class="col align-middle" style="line-height:31px;">
                총 게시물 : {{bo_data.total}}
            </div>

            <div class="col-md-6">
                <b-form @submit.prevent="index" inline ref="form" class="float-right">
                    <div class="input-group input-group-sm">
                        <input type="text" v-model="sch_frm.sch_txt" class="form-control" placeholder="검색어 입력" />
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Search</button>
                        </div>
                    </div>
                    <input type="hidden" v-model="sch_frm.page" />
                </b-form>
            </div>
        </div>

        <table class="table table-striped table-hover">
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
                <template v-if="bo_data.data && bo_data.data.length">
                <tr v-for="(row, idx) in bo_data.data" :key="idx">
                    <th scope="row">
                        {{numCalc(idx)}}
                    </th>
                    <td>
                        <a :href="'/board/'+bo_cd+'/show/'+row.bo_id">{{row.bo_subject}}</a>
                    </td>
                    <td>{{row.bo_writer}}</td>
                    <td>{{ row.created_at | dateFormat }}</td>
                </tr>
                </template>
                <tr v-else><td colspan="4" class="text-center"><b-alert variant="danger" show>No Item</b-alert></td></tr>
            </tbody>
        </table>
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6 text-right">
                <router-link :to="{name: 'bo_create', params: { bo_cd:bo_cd }}" class="btn btn-sm btn-primary">글쓰기</router-link>
            </div>
        </div>
        <pagination :data="bo_data" align="center" @pagination-change-page="setPage"></pagination>
    </div>
</template>
<script>

import http from '@/api/http';
import { mapState } from 'vuex';
import { common } from "@/mixins/common";
export default {
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            sch_frm:{
                sch_txt:'',
                page:0,
            },
            // loading:true,
            error: null,
        }
    },
    // created() {
    //     this.fetchData();
    // },
    computed: {
        // ...mapState('board', ['data', 'loading']),
        ...mapState('board', ['bo_info', 'loading', 'bo_data']),

    },
    // watch: {
    //     '$route.params.bo_cd': function (bo_cd) {
    //         console.log(bo_cd);
    //         this.index();
    //     }
    // },
    beforeRouteUpdate (to, from, next) {
        this.bo_cd = to.params.bo_cd;
        this.index();
        next();
    },
    methods: {
        setPage(page) {
            this.sch_frm.page = page;
            this.index();
        },
        getFrmQueryString(){
            return Object.keys(this.sch_frm).map(key => key + '=' + this.sch_frm[key]).join('&');
        },
        index() {
            const qryString = this.getFrmQueryString();
            this.$store.dispatch('board/index', { bo_cd:this.bo_cd, qryString:qryString });
        },
        numCalc(i) {
            return this.bo_data.total - (this.bo_data.current_page - 1) * this.bo_info.row - i ;
        },

        // index() {
        //     this.$store.dispatch('board/index', { bo_cd:this.$route.params.bo_cd });
        // },


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
    mixins:[common],
}
</script>
