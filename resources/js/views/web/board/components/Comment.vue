<template>
<article id="comment">
    <hr>
    <h5>댓글 <small>{{ bo_comment.length }}개</small></h5>
    <ul class="container"
        v-if="bo_comment && bo_comment.length">

        <template
            v-for="co in bo_comment">
        <li class="row pillar"
            :id="'comment_'+co.bo_id"
            :style="{paddingLeft:calcPl(co.bo_co_seq_cd)+'px'}">

            <div class="col-md-6 col-12">
                <span><b-icon icon="person-fill"></b-icon> {{co.bo_writer}}</span>
                <span><b-icon icon="calendar-date-fill"></b-icon> {{co.created_at}}</span>
            </div>

            <div class="col-md-6 col-12 text-right">
                <b-button variant="success" size="sm"><b-icon icon="hand-thumbs-up"></b-icon></b-button>
                <b-button variant="danger" size="sm"><b-icon icon="hand-thumbs-down"></b-icon></b-button>
                <b-button variant="secondary" size="sm"><b-icon icon="chat-left-dots-fill"></b-icon></b-button>

                <template v-if="$parent.isMine(co.created_id)">
                    <b-button variant="warning" size="sm"><b-icon icon="scissors"></b-icon></b-button>
                    <b-button variant="danger" size="sm"><b-icon icon="trash-fill"></b-icon></b-button>
                </template>
            </div>
            <div v-html="co.bo_content" class="col-12 bo_content" />
            <div class="box_co"></div>
        </li>
        </template>
    </ul>
    <form ref="form" @submit.prevent="write">
        <div class="input-group">
            <label class="input-group-text cm_file">
                <b-icon icon="camera"></b-icon>
                <input type="file" id="file" class="d-none" />
            </label>
            <textarea class="form-control" name="bo_content" v-model="bo_content"></textarea>
            <b-button variant="outline-secondary" size="sm" type="submit">등록</b-button>
        </div>
        <p class="fileName"></p>
    </form>

<!--
<form id="frm_comment" action="{{ route('board.store', $bo_cd) }}" method="post" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="bo_papa_id" value="{{ $bo->bo_id??'' }}" />
    <input type="hidden" name="wri_type" value="comment" />
    <div class="input-group">
        <label class="input-group-text cm_file">
            <i class="bi bi-camera"></i>
            <input type="file" name="fi_id[]" class="d-none" />
        </label>
        <textarea class="form-control" name="bo_content"></textarea>
        <button class="btn btn-outline-secondary" type="submit">등록</button>
    </div>
    <p class="fileName"></p>
</form> -->

</article>
</template>

<script>
export default {
    props:['bo_cd', 'bo_id', 'bo_comment'],
    data() {
        return {
            bo_content:'asd',
            bo_papa_id: this.bo_id,
        };
    },
    computed: {

    },
    methods: {
        write() {
            let frm = new FormData();
            let file = document.getElementById("file");

            frm.append("wri_type", 'comment');
            frm.append("bo_papa_id", this.bo_papa_id);
            frm.append("file", file.files[0]);
            frm.append("bo_subject", 'comment');
            frm.append("bo_content", this.bo_content);

            frm.append('fi_type', 'board');
            frm.append('fi_path', this.bo_cd);
            frm.append('is_thumb', true);

            this.$store.dispatch('board/store', {bo_cd:this.bo_cd, frm:frm});

            // const data = this.getFormData("form");
            // this.$store.dispatch('board/store', { wri_type:'comment', bo_cd:this.bo_cd, bo_papa_id:this.bo_id, frm:this.frm });
        },
        calcPl(dp) {
            return (dp.length-1)*30;
        },
    },
    mounted() {
        // this.index();
    },
}
</script>

<style lang="css" scoped>

#bo_show #comment h5 { margin-bottom:1rem; }
#bo_show #comment>ul>li { border-bottom:1px solid #CCC; margin-bottom:1rem; padding-bottom:1rem; }
#bo_show #comment #frm_comment .cm_file { font-size:1.5rem; background-color:#D8BCF5; padding:2rem 3rem; cursor:pointer;  }
#bo_show #comment #frm_comment button { padding:2rem 3rem; }
#bo_show #comment #frm_comment .fileName { margin-top:1rem; }
#bo_show #comment #frm_comment .fileName .piece { border:1px solid #ddd; border-radius:0.3rem; padding:0.1rem 0.3rem; }
#bo_show #comment #frm_comment .fileName .piece span { margin-left:0.5rem; }

</style>
