<?php

namespace App\Filters;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

abstract class Filters
{
    /**
     * List of available filters for the model
     *
     * @var array of strings
     */
    protected $filters = [];

    protected $request;
    protected $builder;

    /**
     * Create a new Filters instance.
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Apply filters
     *
     * @param Illuminate\Database\Eloquent\Builder
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Get a list of applicable filters
     *
     * @return array of [$filter => $value]
     */
    protected function getFilters()
    {
        return array_intersect_key($this->request->all(), array_flip($this->filters));
    }
}
