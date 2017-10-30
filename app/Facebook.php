<?php

namespace App;

use App\Post;
use GuzzleHttp\Client;

class Facebook
{
    protected $client;
    protected $state;
    protected $page_id;
    protected $page_access_token;

    /**
     * Create and inialiaze new Facebook instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->page_id = config('social.facebook.page_id');
        $this->page_access_token = config('social.facebook.page_access_token');
        $this->state = str_random(20);
        $this->client = new Client;
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
     * Redirect user to login
     *
     * @return type
     */
    public function login()
    {
        $query = http_build_query([
            'client_id' => config('social.facebook.app_id'),
            'redirect_uri' => config('app.url') . '/facebook/callback',
            'state' => $this->state,
            'scope' => 'publish_pages',
        ]);

        return redirect('https://www.facebook.com/v2.10/dialog/oauth?' . $query);
    }

    // Generating an App Access Token
    public function getAppAccessToken()
    {
        $url = "https://graph.facebook.com/oauth/access_token";
        $options =  [
            'query' => [
                'client_id' => config('social.facebook.app_id'),
                'client_secret' => config('social.facebook.app_secret'),
                'grant_type' => 'client_credentials',
            ]
        ];

        $result = $this->client->get($url, $options);
        $token_data = json_decode((string) $result->getBody(), true);
        $app_access_token = $token_data['access_token'];
        return $app_access_token;
    }

    public function getUserAccessToken($code)
    {
        $client = new Client;
        $url = "https://graph.facebook.com/v2.10/oauth/access_token";
        $options =  [
            'query' => [
                'client_id' => config('social.facebook.app_id'),
                'client_secret' => config('social.facebook.app_secret'),
                'redirect_uri' => config('app.url') . '/facebook/callback',
                'code' => $code,
            ]
        ];
        $result = $client->get($url, $options);
        $token_data = json_decode((string) $result->getBody(), true);
        $user_access_token = $token_data['access_token'];
        return $user_access_token;
    }

    // Get a page access token
    public function getPageAccessToken($user_access_token)
    {
        $page_id = config('social.facebook.page_id');
        $url = "https://graph.facebook.com/" . $page_id;

        $options =  [
            'query' => [
                'fields' => 'access_token',
                'access_token' => $user_access_token,
            ]
        ];

        $result = $this->client->get($url, $options);
        $data = json_decode((string) $result->getBody(), true);

        return $data['access_token'] ?? false;
    }


    public function isValidAccessToken($token)
    {
        $app_access_token = $this->getAppAccessToken();

        $url = "https://graph.facebook.com/debug_token";
        $options =  [
            'query' => [
                'input_token' => $token,
                'access_token' => $app_access_token,
            ]
        ];

        $result = $this->client->get($url, $options);
        $data = json_decode((string) $result->getBody(), true);
        return $data['data']['is_valid'];
    }

    // Post to a page
    public function postToPage($message, $link, $page_access_token)
    {
        $page_id = config('social.facebook.page_id');
        $url = "https://graph.facebook.com/{$page_id}/feed";
        $options =  [
            'form_params' => [
                'message' => $message,
                'link' => $link,
                'access_token' => $page_access_token,
            ]
        ];

        $result = $this->client->post($url, $options);
        return json_decode((string) $result->getBody(), true);
    }

    /**
     * Publish status to a facebook timeline.
     *
     * @param string $message
     * @param string $url
     * @param integer $url_length - max length of twitter shortend links (curretly 23)
     * @return GuzzleHttp\Psr7\Response
     */
    public function postStatus($message, $link)
    {
        $url = "https://graph.facebook.com/{$this->page_id}/feed";

        $options =  ['form_params' => [
            'message' => $message,
            'link' => $link,
            'access_token' => $this->page_access_token,
        ]];

        return $this->client->post($url, $options);
    }

    /**
     * Post 'new article created' status to a facebook timeline.
     *
     * @param App\Post  $post
     * @param string $message
     * @return GuzzleHttp\Psr7\Response
     */
    public function publish(Post $post, $message = null)
    {
        $message = $message ?: 'New post has been published at Monster Blog';

        $link = config('app.url') . '/posts/' . $post->slug;

        return $this->postStatus($message, $link);
    }
}

    // 1. Get access token
    // $response = $http->post('https://graph.facebook.com/oauth/access_token', [
    //     'form_params' => [
    //         'type' => 'client_cred',
    //         'client_id' => $client_id,
    //         'client_secret' => $client_secret,
    //     ],
    // ]);

    // // 2. Post to the page on behalf of the user
    // $response = $http->post('https://graph.facebook.com/140507703248558/feed', [
    //     'form_params' => [
    //         'message' => 'How cool is that!',
    //         'link' => 'https://laracasts.com/series/lets-build-a-forum-with-laravel',
    //         'access_token' => $user_access_token,
    //     ],
    // ]);

    // // 3. Post message & link to the page on behalf of the Page
    // $response = $http->post("https://graph.facebook.com/{$page_id}/feed", [
    //     'form_params' => [
    //         'message' => 'How cool is that!',
    //         'link' => 'http://m-lab.xyz/posts/travis-ci-shifrovanie-peremennykh-sredy',
    //         'access_token' => $page_access_token,
    //     ],
    // ]);

    // // 4. Post Child Attachement to the page on behalf of the Page
    // $response = $http->post('https://graph.facebook.com/140507703248558/feed', [
    //     'form_params' => [
    //         'access_token' => $page_access_token,
    //         'message' => 'Lorem textum',
    //         'object_attachment' => '140507703248558_140560946576567',
    //     ],
    // ]);

    // $result = json_decode((string) $response->getBody(), true);
    // dd($result);
