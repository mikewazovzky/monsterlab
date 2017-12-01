<template>
    <div>
        <comment v-for="(item, index) in items"
            :item="item"
            :key="item.id"
            @deleted="fetch"
            @updated="fetch">
        </comment>
        <comment-create v-if="canCreate" @created="fetch"></comment-create>

        <paginator :dataSet="dataSet" @changed="fetch" ref="paginator"></paginator>
    </div>
</template>

<script>
    import Comment from './Comment.vue';
    import CommentCreate from './CommentCreate.vue';

    export default {
        components: { Comment, CommentCreate },

        // props: ['post'],

        data() {
            return {
                dataSet: {},
                items: []
            }
        },

        created() {
            this.fetch();
        },

        computed: {
            canCreate() {
                return this.authorize('createComment');
            }
        },

        methods: {
            fetch(page) {
                axios.get(this.url(page))
                    .then(this.refresh)
                    .catch(errors => console.error('Failed to load data.'));
            },

            refresh(response) {
                this.items = response.data.data;
                this.dataSet = response.data;
            },

            url(page) {
                if (!page) {
                    let query = location.search.match(/page=(\d+)/);
                    page = query ? query[1] : 1;
                }

                return `${location.pathname}/comments?page=${page}`;
            }
        }
    };
</script>
