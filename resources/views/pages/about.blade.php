@extends('posts.layout')

@section('main')

    <div class="page-header">
        <h1>О проекте</h1>
    </div>
    <p>
        Краткое описание проекта ...
    </p>
    <p>
        Основные компоненты проекта.
    </p>
    <list-group inline-template>
        <div>
            <a href="#" @click.prevent="show = true">open all</a> /
            <a href="#" @click.prevent="show = false">close all</a>
            <ul class="list-group">

                <list-item :show="show">
                    <a slot="href">Users/Profiles</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Posts</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Tags</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Filtering</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Search: database, Algolia, ElasticSearch</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Views Count and Trending</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Archives</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Tracking post changes</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Replies</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Likes [-]</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Authorization System</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Notifications</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">External API [-]</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

                <list-item :show="show">
                    <a slot="href">Integration with Social Media [-]</a>
                    <p>A paragraph for the collapsable content.</p>
                </list-item>

            </ul>
        </div>
    </list-group>
@endsection
