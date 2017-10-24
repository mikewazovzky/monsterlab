<?php

namespace App;

use Carbon\Carbon;
use App\Events\PostCreated;
use App\Filters\PostFilters;
use App\Tools\HTMLProcessor;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Mikewazovzky\Adjustable\Adjustable;

class Post extends Model
{
    /**
     * Makes the model searchable by scout
     * @trait
     */
    use Searchable;
    use Adjustable;
    use TrackViewsCount;

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
     * The attributes that should be hidden for arrays (toArray()) and json (json_encode()).
     *
     * @var array
     */
    protected $hidden = [];

    // protected $dispatchesEvents = [
    //     'created' => PostCreated::class,
    // ];

    /**
     * The relationships that shoudl be eager loaded every tyme the model is retrieved.
     *
     * @var array of strings
     */
    protected $with = ['tags', 'user'];

    /**
     * Hook to event:created to make a slug & dispatch event:PostCreated
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($post) {
            $post->update([
                'slug' => $post->title
            ]);

            event(new PostCreated($post));
        });
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
     * Clear views count and delete the post
     *
     * @param type name
     * @return type
     */
    public function delete()
    {
        $this->clearViewsCount();

        parent::delete();
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
     * for archives vidgets.
     * Original code uses mysql year() and month() method and is not compliant with sqlite.
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
     * Overide TrackViewsCount::cacheData method to fetch data [post, user]
     * required for Trending vidget.
     *
     * @return string
     */
    public function cacheData()
    {
        return json_encode([
            'title' => $this->title,
            'slug' => $this->slug,
            'user' => [
                'name' => $this->user->name,
                'slug' => $this->user->slug,
            ]
        ]);
    }
}
