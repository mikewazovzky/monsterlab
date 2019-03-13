<template>
    <div>
        <h2>Search</h2>

        <ais-index
            app-id="3FC8VEFCGP"
            api-key="f4d5ead510eebdccb6e8b302ca482993"
            :query="query"
            :index-name="indexName">

            <ais-search-box>
                <div class="input-group">
                    <ais-input
                        placeholder="Search posts by title or content ..."
                        :class-names="{ 'ais-input': 'form-control' }">
                    </ais-input>

                    <span class="input-group-btn">
                        <ais-clear :class-names="{'ais-clear': 'btn btn-default'}">
                            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                        </ais-clear>
                        <button class="btn btn-default" type="submit">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                        </button>
                    </span>
                </div>
            </ais-search-box>

            <ais-stats></ais-stats>

            <a href="https://www.algolia.com">
                <img class="algolia-image pull-right" src="https://www.algolia.com/assets/pricing_new/algolia-powered-by-ac7dba62d03d1e28b0838c5634eb42a9.svg">
            </a>

            <hr>

            <div class="row">
                <div class="col-sm-3">
                    <ais-refinement-list attribute-name="tags"
                        :class-names="{
                            'ais-refinement-list': 'tags-list',
                            'ais-refinement-list__item': 'checkbox',
                            'ais-refinement-list__count': 'badge'
                        }">
                        <h5 slot="header"><strong>Refine search by tag(s)</strong></h5>
                    </ais-refinement-list>
                </div>

                <div class="col-sm-9">
                    <ais-no-results>
                        <template slot-scope="props">
                            No results found for <i>{{ props.query }}</i>.
                        </template>
                    </ais-no-results>

                    <ais-results>
                        <template slot-scope="{ result }">
                            <a :href="'/posts/' + result.slug">
                                <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                            </a>
                            <br><strong>Body</strong>: <ais-snippet :result="result" attribute-name="body"></ais-snippet>...
                            <br><strong>Tags</strong>: [<ais-snippet :result="result" attribute-name="tagsList"></ais-snippet>]
                            <hr>
                        </template>
                    </ais-results>

                    <div class="centered">
                        <ais-pagination
                            class="pagination"
                            :class-names="{
                                'ais-pagination': 'pagination',
                                'ais-pagination__item--active': 'active',
                                'ais-pagination__item--disabled': 'disabled'
                            }"
                            v-on:page-change="onPageChange">
                        </ais-pagination>
                    </div>
                </div>
            </div>
        </ais-index>
    </div>
</template>

<script>
    export default {
        props: ['query', 'prefix'],

        computed: {
            indexName() {
                return `${this.prefix}posts`;
            }
        },

        methods: {
            onPageChange() {
                window.scroll(0, 0);
            }
        }
    }
</script>

<style scoped>
    .centered { text-align: center; }
    .ais-stats { display: inline; }
    .algolia-image { margin-top: 3px; }
</style>
