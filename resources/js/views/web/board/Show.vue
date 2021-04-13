<template>
    <div class="bo_show">
        <h4>{{$bo_nm}}</h4>

<!--        <div id="bo_show" class="container">
            <h3>{{$bo->bo_subject}}</h3>

            <ul class="list-inline bd_info">
                <li class="list-inline-item"><i class="bi bi-person-fill"></i> {{$bo->bo_writer}}</li>
                <li class="list-inline-item"><i class="bi bi-calendar-date-fill"></i> {{$bo->created_at}}</li>
                <li class="list-inline-item"><i class="bi bi-eye-fill"></i> {{$bo->bo_click}}</li>
                @isset($add_file)
                <li class="list-inline-item add_file">
                    <i class="bi bi-file-earmark-arrow-down-fill"></i>
                    @foreach($add_file as $fi)
                    <a href="">{{$fi->fi_original}}</a>
                    @endforeach
                </li>
                @endisset
            </ul>
            <hr />


        </div>-->

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
        show() {
            this.$store.dispatch('board/show', { bo_cd:this.$route.params.bo_cd, bo_id });
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
