<?php

namespace App;

use App\Post;
use App\Events\CommentCreated;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The relationships to always eager-load.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * The attributes that should be casted to specified type.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'commentable_id' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
    ];

    /**
     * Get a user the reply belongs to.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get a model instance the reply belongs to.
     *
     * @return Illuminate\Database\Eloquent\Relations\morphTo
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get a post the reply belongs to.
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsTo | null
     */
    public function post()
    {
        return $this->commentable_type === Post::class ?  $this->commentable() : null;
    }
}
