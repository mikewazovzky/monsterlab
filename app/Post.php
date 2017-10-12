<?php

namespace App;

use Carbon\Carbon;
use App\Events\PostCreated;
use App\Filters\PostFilters;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    /**
     * The attributes that are NOT mass assignable. Yolo!
     *
     * @var array
     */
    protected $guarded = [];
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
     * The relationships that shoul be eager loaded every tyme the model is retrieved.
     *
     * @var array of strings
     */
    protected $with = ['tags', 'user'];

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

    public function setSlugAttribute($value)
    {
        $slug = str_slug($value);

        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }

        $this->attributes['slug'] = $slug;
    }
}
