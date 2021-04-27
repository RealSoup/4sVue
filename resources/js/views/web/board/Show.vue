<template>
<div id="bo_show">

    <h3>{{bo_con.bo_subject}}</h3>

    <ul class="list-inline bd_info">
        <li class="list-inline-item"><b-icon icon="person-fill"></b-icon> {{bo_con.bo_writer}}</li>
        <li class="list-inline-item"><b-icon icon="calendar-date-fill"></b-icon> {{bo_con.created_at}}</li>
        <li class="list-inline-item"><b-icon icon="eye-fill"></b-icon> {{bo_con.bo_click}}</li>

        <li class="list-inline-item add_file" v-if="bo_con.add_file && bo_con.add_file.length">
            <b-icon icon="file-earmark-arrow-down-fill"></b-icon>
            <template v-for="file in bo_con.add_file">
                <a href="">{{file.fi_original}}</a>
            </template>


        </li>

    </ul>
    <hr />

    <div class="con">
        <!-- @isset($img_file)
        @foreach($img_file as $fi)
        <img src="{{$fi->getSrc()}}" class='me-auto ms-auto d-block' />
        @endforeach
        @endisset -->
        <template v-if="bo_con.img_file && bo_con.img_file.length">
            <img v-for="(image, index) in bo_con.img_file" :src="image.src" class='me-auto ms-auto d-block' />
        </template>
        <hr />

        <div v-html="bo_con.bo_content" />

        <hr />
    </div>

    <div class="row">
        <div class="col-6">
            <router-link :to="{name: 'bo_index', params: { bo_cd:bo_cd }}" class="btn btn-sm btn-light">목록</router-link>
        </div>
        <div class="col-6 text-right">
            <router-link :to="{name: 'bo_edit', params: { bo_cd:bo_cd, bo_id:bo_id }}" class="btn btn-sm btn-warning">수정</router-link>
        </div>
    </div>

    <Comment
        v-if="bo_info.is_comment"
        :bo_cd='bo_cd'
        :bo_id='bo_id'
        :bo_comment='bo_comment' />

</div>
</template>
<script>
import http from '@/api/http';
import { mapState } from 'vuex';
import Comment from "./components/Comment.vue"

export default {
    name: 'show',
    components: {
        Comment,
    },
    data() {
        return {
            bo_cd:this.$route.params.bo_cd,
            bo_id:this.$route.params.bo_id,
        };
    },
    computed: {
        ...mapState('board', ['bo_info', 'loading', 'bo_con', 'bo_comment']),
    },
    methods: {
        show() {
            this.$store.dispatch('board/show', { bo_cd:this.bo_cd, bo_id:this.bo_id });
        },
    },
    mounted() {
        this.show();
    },
}
</script>

<style media="screen">
#bo_show h3 { margin:2rem 0 1rem 0; }
#bo_show .bd_info { line-height:1.4rem; }
#bo_show .bd_info li { margin-right:1.5rem; }
#bo_show .bd_info .add_file { margin-left:24px; }
#bo_show .bd_info .add_file i { margin:0 3px 0 -24px; }
#bo_show .bd_info .add_file a { color:#FFF; background-color:#888; margin-right:1rem; letter-spacing:-1px; border:1px dashed #CCC; border-radius:0.3rem; padding:0.1rem 0.3rem; }
#bo_show .con { margin-bottom:3rem; line-height:1.5rem; }
</style>
