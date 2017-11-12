{{-- FAVORITE VIDGET --}}
@auth
    <favorite-vidget></favorite-vidget>
@endauth

{{-- SEARCH VIDGET --}}
@include('posts.sidebar.search')

{{-- TAGS VIDGET --}}
@include('posts.sidebar.tags')

{{-- LATEST POSTS VIDGET --}}
@include('posts.sidebar.latest')

{{-- TRENDING POSTS VIDGET --}}
@include('posts.sidebar.trending')

{{-- ARCHIVES VIDGET --}}
@include('posts.sidebar.archives')

{{-- ABOUT VIDGET --}}
@include('posts.sidebar.about')
