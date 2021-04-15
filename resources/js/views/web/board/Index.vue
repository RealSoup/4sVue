<template>
    <div class="bo_index">
        <h2>{{bo_nm}}</h2>
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
                <b-form @submit.prevent="getList" inline ref="form" class="float-right">
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
                        <a :href="'/board/'+bo_cd+'/view/'+row.bo_id">{{row.bo_subject}}</a>
                    </td>
                    <td>{{row.bo_writer}}</td>
                    <td>{{row.bo_date}}</td>
                </tr>
                </template>
                <tr v-else><td colspan="4" class="text-center"><b-alert variant="danger" show>No Item</b-alert></td></tr>
            </tbody>
        </table>

        <pagination :data="bo_data" align="center" @pagination-change-page="setPage"></pagination>
    </div>
</template>
<script>

import http from '@/api/http';
import { mapState } from 'vuex';
export default {
    data() {
        return {
            bo_nm:'',
            bo_data:{},
            row:10,
            bo_cd:this.$route.params.bo_cd,
            sch_frm:{
                sch_txt:'',
                page:0,
            },
            loading:true,
            error: null,
        }
    },
    // created() {
    //     this.fetchData();
    // },
    computed: {
        // ...mapState('board', ['data', 'loading']),


    },
    methods: {
        setPage(page) {
            this.sch_frm.page = page;
            this.getList();
        },
        getFrmQueryString(){
            return Object.keys(this.sch_frm).map(key => key + '=' + this.sch_frm[key]).join('&');
        },
        async getList(e) {
            const frmParam = this.getFrmQueryString();
            try {
                await http.get('/api/board/'+this.bo_cd+'?' + frmParam).then(res => {
                    if (res.status === 200) {
                        this.row = res.data.row;
                        this.bo_nm = res.data.bo_nm;
                        this.bo_data = res.data.board;
                        this.loading = false;
                        // context.commit('setData', {data:res.data});
                    }
                }).catch(function (error) {
                    console.log(error);
                });


            } catch (e) {
                alert(e.response.data.error);
            }
        },
        numCalc(i) {
            return this.bo_data.total - (this.bo_data.current_page - 1) * this.row - i ;
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
        this.getList();
    },
}
</script>
