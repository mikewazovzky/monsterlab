<?php

namespace App\Filters;

class PostFilters extends Filters
{
    /**
     * List of available filters for the model
     *
     * @var array of strings
     */
    protected $filters = ['tag'];

    /**
     * Filters posts by tag.
     *
     * @param string $value
     * @return Illuminate\Database\Eloquent\Builder
     */
    protected function tag($value)
    {
        $this->builder = $this->builder->whereHas('tags', function ($query) use ($value) {
            return $query->whereName($value);
        });
    }
}
