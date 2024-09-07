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
        return $this->model::query()
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function create(array $data)
    {

        return $this->model::create($data);
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
        return $this->model::query()->where($field, $value)->first();
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
    public function getData($search=null, $filter=null, $sort='created_at', $direction = 'desc', $limit = null, $paginate=null){

        return $this->model::query()
           
            ->when($search, function ($query) use ($search) {
                return $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('tags', 'like', '%' . $search . '%');

            })
            ->when($filter && $filter != 'all', function ($query) use ($filter) {

                return $query->where('status', $filter);
            })
            ->when($sort, function ($query) use ($sort, $direction) {
                return $query->orderBy($sort, $direction);
            })
            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->when($paginate, function ($query) use ($paginate) {
                return $query->paginate($paginate);
            });
            
           
           
    }
}
