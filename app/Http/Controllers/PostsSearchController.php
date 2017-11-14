<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostsSearchController extends Controller
{
    /**
     * Define required serch engine and redirect to proper action
     *
     * @param type name
     * @return type
     */
    public function search(Request $request)
    {
        $engine = $request['search-type'];
        $query = $request['search-query'];

        switch ($engine) {
            case 'mySQL':
                return $this->mySQL($query);

            case 'algolia':
                return $this->algolia($query);

            case 'elasticsearch':
                return redirect()->action('PostsSearchController@elasticsearch', ['query' => $query]);

            default:
                return back();
        }
    }

    /**
     * Filter posts database via query
     *
     * @param string $query
     * @return Illuninate\Http\Response
     */
    protected function mySQL($query)
    {
        return redirect(route('posts.index', ['search' => $query]));
    }

    /**
     * Search by algolia engine
     *
     * @param string $query
     * @return Illuninate\Http\Response
     */
    protected function algolia($query)
    {
        return view('posts.search-algolia', ['query' => $query]);
    }


    /**
     * Search by elasticsearch engine
     *
     * @param string $query
     * @return Illuninate\Http\Response
     */
    protected function elasticsearch(Request $request)
    {
        $page = request()->page ?: 1;
        $results = [];

        if ($query = $request['query']) {
            $results = Post::search($query)->paginate(10);
        }

        return view('posts.search-elasticsearch', [
            'query' => $query,
            'page' => $page,
            'results' => $results,
        ]);
    }
}
