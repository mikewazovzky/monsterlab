<template>
    <div class="text-center">
    <ul class="pagination" v-if="shouldPaginate">
        <li v-if="prevUrl">
            <a href="" aria-label="Previous" @click.prevent="page--">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>

        <li v-for="link in links">
            <a :class="classes(link)" v-text="link" @click.prevent="page=link"></a>
        </li>

        <li v-if="nextUrl">
            <a href="" aria-label="Next" @click.prevent="page++">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
    </div>
</template>

<script>
    import pagination from '../utilities/pagination';

    export default {
        props: ['dataSet'],

        data() {
            return {
                page: 1,
                prevUrl: false,
                nextUrl: false,
                links: []
            };
        },

        watch: {
            dataSet() {
                this.page = this.dataSet.current_page;
                this.prevUrl = this.dataSet.prev_page_url;
                this.nextUrl = this.dataSet.next_page_url;

                this.updateUrl().updateLinks();
            },

            page() {
                this.broadcast();
            }
        },

        computed: {
            shouldPaginate() {
                return !! this.prevUrl || !! this.nextUrl;
            }
        },

        methods: {
            broadcast() {
                return this.$emit('changed', this.page);
            },

            updateUrl() {
                // history.pushState(null, null, '?page=' + this.page);
                history.replaceState(null, null, '?page=' + this.page);
                return this;
            },

            updateLinks() {
                this.links = pagination(this.page, this.dataSet.last_page);
            },

            classes(link) {
                return [
                    link == this.page ? 'inverted' : '',
                    link == '...' ? 'disabled' : ''
                ];
            }
        }
    };
</script>

<style scoped>
    .inverted { background-color: rgb(48, 151, 209); color: #ffffff; }
    .disabled { pointer-events: none; }
    a:hover { cursor: pointer; cursor: hand; }
</style>
