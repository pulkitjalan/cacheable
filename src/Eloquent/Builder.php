<?php

namespace PulkitJalan\Cacheable\Eloquent;

use Illuminate\Database\Eloquent\Builder as IlluminateBuilder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function find($id, $columns = ['*'], $expire = 60)
    {
        if (is_array($id)) {
            return $this->findMany($id, $columns);
        }

        return Cache::tags($this->model->getTable())->remember($id, $expire, function () use ($id, $columns) {
            return parent::find($id, $columns);
        });
    }

    /**
     * Find a model by its primary key.
     *
     * @param  array  $ids
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function findMany($ids, $columns = ['*'], $expire = 60)
    {
        if (empty($ids)) {
            return $this->model->newCollection();
        }

        return $this->model->newCollection(
            Cache::tags($this->model->getTable())->rememberMany($ids, $expire, function ($ids) use ($columns) {
                return parent::findMany($ids, $columns)->all();
            })
        );
    }

    /**
     * Find a model by its primary key or throw an exception.
     *
     * @param  mixed  $id
     * @param  array  $columns
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function findOrFail($id, $columns = ['*'], $expire = 60)
    {
        $result = $this->find($id, $columns, $expire);

        if (is_array($id)) {
            if (count($result) == count(array_unique($id))) {
                return $result;
            }
        } elseif (! is_null($result)) {
            return $result;
        }

        throw (new ModelNotFoundException)->setModel(get_class($this->model));
    }
}
