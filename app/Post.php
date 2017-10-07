<?php

namespace App;

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

    /**
     * The relationships that shoul be eager loaded every tyme the model is retrieved.
     *
     * @var array of strings
     */
    protected $with = ['tags'];

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
}
