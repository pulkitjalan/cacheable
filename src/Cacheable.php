<?php

namespace PulkitJalan\Cacheable;

use Illuminate\Support\Facades\Cache;
use PulkitJalan\Cacheable\Eloquent\Builder;

trait Cacheable
{
    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        static::updated(function ($model) {
            Cache::tag($this->getTable())->forget($model->{$model->getKeyName()});
        }, -1);

        static::saved(function ($model) {
            Cache::tag($this->getTable())->forget($model->{$model->getKeyName()});
        }, -1);

        static::deleted(function ($model) {
            Cache::tag($this->getTable())->forget($model->{$model->getKeyName()});
        }, -1);

        static::restored(function ($model) {
            Cache::tag($this->getTable())->forget($model->{$model->getKeyName()});
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
