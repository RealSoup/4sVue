<template>
    <div class="lists">
        <div class="loading text-center p-5" v-if="loading">
            <b-spinner variant="success" label="Spinning"></b-spinner>
        </div>

        <div v-if="error" class="error">
            {{ error }}
            <button @click.prevent="fetchData"> Try Again </button>
        </div>

        <ul v-if="lists">
            <li v-for="(row, idx) in lists" :key="idx">
                <strong>제목:</strong> {{ row.bo_subject }},
                <strong>내용:</strong> {{ row.bo_content }}
            </li>
        </ul>
    </div>
</template>
<script>
export default {
    data() {
        return {
            loading: false,
            lists: null,
            error: null,
        };
    },
    created() {
        this.fetchData();
    },
    methods: {
        fetchData() {
            this.error = this.lists = null;
            this.loading = true;
            axios
                .get('/api/board/normal')
                .then(response => {
                    this.loading = false;
                    this.lists = response.data.data;
                    console.log(response.data);
                }).catch(error => {
                    this.loading = false;
                    this.error = error.response.data.message || error.message;
                    console.log(456);
                });
        }
    }
}
</script>
