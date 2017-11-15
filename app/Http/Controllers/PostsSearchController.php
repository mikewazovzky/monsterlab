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
                return redirect()->action('PostsSearchController@elasticsearch', ['search' => $query]);

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
    protected function algolia($search)
    {
        return view('posts.search-algolia', ['search' => $search]);
    }

    /**
     * Search by elasticsearch engine
     *
     * @param string $query
     * @return Illuninate\Http\Response
     */
    protected function elasticsearch(Request $request)
    {
        if (!$this->checkElasticsearch()) {
            flash()->error('Error! Elasticsearch Server is not available.');
            return redirect(route('posts.index'));
        }

        $page = request()->page ?: 1;
        $posts = [];

        if ($search = $request->search) {
            $posts = Post::search($search)->paginate(10);
        }

        return view('posts.search-elasticsearch', [
            'search' => $search,
            'page' => $page,
            'posts' => $posts,
        ]);
    }

    /**
     * Check if Elasticsearch server [0] is available
     *
     * @param type name
     * @return type
     */
    protected function checkElasticsearch()
    {
        if (config('scout.driver') !== 'elasticsearch') {
            return false;
        }

        $hosts = config('scout.elasticsearch.hosts');
        $url = $hosts[0] . ':9200';

        try {
            $result = file_get_contents($url);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
