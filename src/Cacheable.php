<?php

namespace PulkitJalan\Cacheable;

use PulkitJalan\Cacheable\Eloquent\Builder;

trait Cacheable
{
    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param  \Illuminate\Database\Query\Builder $query
     * @return \PulkitJalan\Cacheable\Eloquent\Builder|static
     */
    public function newEloquentBuilder($query)
    {
        return new Builder($query);
    }
}
