<?php

namespace PulkitJalan\Cacheable;

use Illuminate\Support\Facades\Cache;
use PulkitJalan\Cacheable\Eloquent\Builder;

trait Cacheable
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::updated(function ($model) {
            Cache::tags($model->getTable())->forget($model->{$model->getKeyName()});
        }, -1);

        static::saved(function ($model) {
            Cache::tags($model->getTable())->forget($model->{$model->getKeyName()});
        }, -1);

        static::deleted(function ($model) {
            Cache::tags($model->getTable())->forget($model->{$model->getKeyName()});
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
}
