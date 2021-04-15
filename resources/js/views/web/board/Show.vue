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
import http from '@/api/http';
export default {
    data() {
        return {
            bo_nm:'',
            bo_cd:this.$route.params.bo_cd,
            bo_id:this.$route.params.bo_id,
            post: null,
            loading: true,
        };
    },
    // created() {
    //     this.fetchData();
    // },
    computed: {
        // ...mapState('board', ['data', 'loading']),


    },
    methods: {
        async getPost() {
            try {
                await http.get('/api/board/'+this.bo_cd+'/show/'+bo_id).then(res => {
                    console.log(res.data);
                    if (res.status === 200) {
                        this.bo_nm = res.data.bo_nm;
                        this.post = res.data;
                        this.loading = false;
                    }
                }).catch(function (error) {
                    console.log(error);
                });


            } catch (e) {
                alert(e.response.data.error);
            }
        },

    },
    mounted() {
        this.getPost();
    },
}
</script>
