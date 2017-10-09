<template>
    <div>
        <reply v-for="(item, index) in items"
            :item="item"
            :key="item.id"
            @deleted="fetch"
            @updated="fetch">
        </reply>
        <reply-create v-if="canCreate" @created="fetch"></reply-create>

        <paginator :dataSet="dataSet" @changed="fetch" ref="paginator"></paginator>
    </div>
</template>

<script>
    import Reply from './Reply.vue';
    import ReplyCreate from './ReplyCreate.vue';

    export default {
        components: { Reply, ReplyCreate },

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
                return this.authorize('createReply');
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

                return `${location.pathname}/replies?page=${page}`;
            }
        }
    };
</script>
