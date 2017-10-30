<?php

namespace App;

use App\Post;
use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use GuzzleHttp\Subscriber\Oauth\Oauth1;

class Twitter
{
    protected $client;

    /**
     * Create and inialiaze new Twitter instance.
     *
     * @return void
     */
    public function __construct()
    {
        $stack = HandlerStack::create();

        $middleware = new Oauth1([
            'consumer_key'    => config('social.twitter.key'),
            'consumer_secret' => config('social.twitter.secret'),
            'token' => config('social.twitter.token'),
            'token_secret' => config('social.twitter.token_secret'),
        ]);

        $stack->push($middleware);

        $this->client = new Client([
            'base_uri' => 'https://api.twitter.com/1.1/',
            'handler' => $stack,
            'auth' => 'oauth',
        ]);
    }

    /**
     * Make post request.
     *
     * @param string $url
     * @param array $params
     * @return GuzzleHttp\Psr7\Response
     */
    public function post($url, $params = [])
    {
        return $this->client->post($url, $params);
    }

    /**
     * Make get request.
     *
     * @param string $url
     * @param array $params
     * @return GuzzleHttp\Psr7\Response
     */
    public function get($url, $params = [])
    {
        return $this->client->get($url, $params);
    }

    /**
     * Create status object: message and link required.
     *
     * @param string $message
     * @param string $url
     * @param integer $url_length - max link length shortend by twitter (curretly 23)
     * @return GuzzleHttp\Psr7\Response
     */
    protected function status($message, $url)
    {
        $url_length = 25;
        $tweet = [];
        $tweet['status'] = mb_substr($message, 0, 136 - $url_length) . '... ' . $url;
        return $tweet;
    }

    /**
     * Post status to a twitter timeline.
     *
     * @param string $message
     * @param string $url
     * @param integer $url_length - max length of twitter shortend links (curretly 23)
     * @return GuzzleHttp\Psr7\Response
     */
    public function postStatus($message, $url)
    {
        $status = $this->status($message, $url);

        return $this->client->post('statuses/update.json', [ 'query' => $status]);
    }

    /**
     * Post 'new article created' status to a twitter timeline.
     *
     * @param App\Post  $post
     * @param string $message
     * @return GuzzleHttp\Psr7\Response
     */
    public function publish(Post $post, $message = null)
    {
        $message = $message ?: 'New post has been published at Monster Blog';

        return $this->postStatus($message, route('posts.show', $post));
    }
}
