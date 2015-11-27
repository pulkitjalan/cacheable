<?php

namespace PulkitJalan\Cacheable\Eloquent;

use Illuminate\Database\Eloquent\Builder as IlluminateBuilder;
use Illuminate\Support\Facades\Cache;

class Builder extends IlluminateBuilder
{
    /**
     * Find a model by its primary key.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|null
     */
    public function find($id, $columns = ['*'])
    {
        if (! $this->isBasicQuery()) {
            return parent::find($id, $columns);
        }

        if (is_array($id)) {
            return $this->findMany($id, $columns);
        }

        return Cache::tags($this->model->getTable())->remember(
            $id,
            $this->model->cacheExpiry,
            function () use ($id, $columns) {
                return parent::find($id, $columns);
            }
        );
    }

    /**
     * Find a model by its primary key.
     *
     * @param  array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*'])
    {
        if (! $this->isBasicQuery()) {
            return parent::findMany($ids, $columns);
        }

        if (empty($ids)) {
            return $this->model->newCollection();
        }

        return $this->model->newCollection(
            Cache::tags($this->model->getTable())->rememberMany(
                $ids,
                $this->model->cacheExpiry,
                function ($ids) use ($columns) {
                    return parent::findMany($ids, $columns)->all();
                }
            )
        );
    }

    /**
     * Check if the current query is a basic query or has had some
     * conditions (where, joins, etc) attached to it.
     * 
     * @return boolean
     */
    protected function isBasicQuery()
    {
        $freshQuery = $this->getQuery()
            ->newQuery()
            ->from($this->getModel()->getTable());

        return $this->getQuery() == $freshQuery;
    }
}
