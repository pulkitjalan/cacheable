<?php

namespace PulkitJalan\Cacheable;

use Illuminate\Support\Facades\Cache;
use PulkitJalan\Cacheable\Eloquent\Builder;

trait Cacheable
{
    /**
     * Set the cache expiry time.
     *
     * @var int
     */
    public $cacheExpiry = 1440;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->refresh();
        }, -1);

        static::deleted(function ($model) {
            $model->refresh();
        }, -1);
    }

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

    /**
     * Refresh the current models cache.
     *
     * @return $this
     */
    public function refresh()
    {
        Cache::tags($this->getTable())->forget($this->{$this->getKeyName()});

        return $this;
    }
}
