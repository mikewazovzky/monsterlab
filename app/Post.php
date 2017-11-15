<?php

namespace App;

use Carbon\Carbon;
use App\Events\PostCreated;
use App\Filters\PostFilters;
use App\Tools\HTMLProcessor;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Mikewazovzky\Adjustable\Adjustable;
use Mikewazovzky\Favoritable\Favoritable;

class Post extends Model
{
    use Searchable, Adjustable, Cacheable, Favoritable;

    /**
     * The attributes that are NOT mass assignable. Yolo!
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be casted to specific data type
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer'
    ];

    /**
     * The attributes that should be hidden for arrays via toArray() and json via json_encode().
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The events fired upon model operations.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => PostCreated::class,
    ];

    /**
     * The relationships that should be eager loaded every time the model is retrieved.
     *
     * @var array of strings
     */
    protected $with = ['tags'];

    /**
     * List of custom attributes that will be appended when
     * model is casted toArray or to JSON object
     *
     * @var array
     */
    protected $appends = [];

    /**
     * Hook to model:created event to make a post slug
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            $post->slug = $post->title;
        });
    }

    /**
     * Create new post. Associate tags with the post.
     *
     * @param array $attributes
     * @param array $tagList
     * @return App\Post
     */
    public static function publish($attributes, $tagList = [], $user = null)
    {
        $user = $user ?? auth()->user();

        $post = $user->posts()->create($attributes);

        $post->syncTags($tagList);

        return $post;
    }

    /**
     * Sync post tags.
     *
     * @param array $tagList
     * @return void
     */
    public function syncTags($tagList = [])
    {
        $this->tags()->sync($tagList);
    }

    /**
     * Get the route key name for Laravel.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get a user the post belongs to.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get tags attached to the post.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Get replies associated to the to post.
     *
     * @return Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     *  Applies existing PostFilters to the post
     *
     * @param Illuminate\Database\Eloquent\Builder $query
     * @param App\Filters\PostFilters
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, PostFilters $filters)
    {
        return $filters->apply($query);
    }

    /**
     * Get statistics on number of posts published within specifc time period [year:month]
     * for sidebar archives vidgets.
     * The original (commented out) code uses mysql year() and month() method and
     * is not compliant with sqlite.
     *
     * @return array
     */
    public static function archives()
    {
        // $posts = Post::selectRaw('year(created_at) as year, monthname(created_at) as month, count(*) as published')
        //     ->groupBy('year', 'month')
        //     ->orderByRaw('min(created_at) desc')
        //     ->get()
        //     ->toArray();

        $posts = Post::orderBy('created_at', 'desc')->pluck('created_at')->toArray();
        $stats = [];

        foreach ($posts as $post) {
            $newItem = true;
            $year = $post->year;
            $month = $post->format('F');

            foreach ($stats as $index => $item) {
                if ($item['year'] === $year && $item['month'] === $month) {
                    $stats[$index]['published']++;
                    $newItem = false;
                }
            }

            if ($newItem) {
                $stats[] = ['year' => $year, 'month' => $month, 'published' => 1];
            }
        }

        return $stats;
    }

    /**
     * Set unique post slug attribute
     *
     * @param string $value
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }

    /**
     * Set title attribute striped from html tags
     *
     * @param string $value
     * @return void
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title']  = strip_tags($value);
    }

    /**
     * Set body attribute to purified html content
     *
     * @param string $value
     * @return void
     */
    public function setBodyAttribute($value)
    {
        $processor = new HTMLProcessor();

        $this->attributes['body']  = $processor->process($value);
    }

    public function getTitle(string $search = '')
    {
        return $this->highlight($search, $this->title);
    }

    public function getExcerpt(string $search = '', int $symbols = 399)
    {
        return $this->highlight($search, (mb_substr(strip_tags($this->body), 0, $symbols))) . ' ...';
    }

    /**
     * Convert model to data object persisted into search engine database via scout
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $user = $this->user;

        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'body' => $this->body,
            'created_at' => $this->created_at->toDateString(),
            'tags' => $this->tags()->pluck('name'),
            'tagsList' => implode(',', $this->tags()->pluck('name')->all()),
            'user_name' => $user->name,
            'user_slug' => $user->slug,
        ];
    }

    /**
     * Convert model to data object persisted into cache layer.
     * Persisted attributes are required by Trending vidget.
     *
     * @return string
     */
    public function toCacheableArray()
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'user' => [
                'name' => $this->user->name,
                'slug' => $this->user->slug,
            ]
        ];
    }

    protected function highlight(string $search, string $subject)
    {
        $replace = "<span class=\"highlight\">{$search}</span>";

        return str_replace($search, $replace, $subject);
    }
}
