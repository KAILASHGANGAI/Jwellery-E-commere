<?php

namespace App\Repositories;

use App\Repositories\Contracts\CommonRepositoryInterface;

class CommonRepository implements CommonRepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function all($limit = 30)
    {
        return $this->model->limit($limit)->get();
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update($id, array $data)
    {
        $product = $this->model->find($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }

    public function delete($id)
    {
        return $this->model->destroy($id);
    }

    public function findByField($field, $value)
    {
        return $this->model->where($field, $value)->first();
    }

    public function createOrUpdateByField($field, $value, $data)
    {
        $data = $this->model->where($field, $value)->first();
        if ($data) {
            $data->update($data);
            return $data;
        }
        return $this->model->create($data);
    }
}
