{{-- SEARCH PANEL --}}
<div class="panel panel-primary">

    <div class="panel-heading">
        <strong>Search</strong>
    </div>

    <div class="panel-body">
        <form method="GET" action="{{ route('posts.search') }}">

            <div class="input-group">
                <input type="text" name="search-query" class="form-control" placeholder="Search posts title and body by query ..." />
                <div class="input-group-btn">
                    <button class="btn btn-info btn-md" type="submit">
                        <span class="glyphicon glyphicon-search"></span>
                    </button>
                </div>
            </div>

            <div class="text-center mt-1">
                <label class="radio-inline">
                    <input type="radio" name="search-type" id="mySQL" value="mySQL" checked> mySQL
                </label>
                <label class="radio-inline">
                    <input type="radio" name="search-type" id="algolia" value="algolia" {{-- disabled --}}> algolia
                </label>
                <label class="radio-inline">
                    <input type="radio" name="search-type" id="elasticsearch" value="elasticsearch"> elastic
                </label>
            </div>

        </form>
    </div>
</div>
