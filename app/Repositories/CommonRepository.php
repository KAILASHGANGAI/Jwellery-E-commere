<?php

namespace App\Repositories;

use App\Repositories\Contracts\CommonRepositoryInterface;

class CommonRepository implements CommonRepositoryInterface
{
    protected $model;

    /**
     * Initializes the repository with a given model instance.
     *
     * @param mixed $model The model instance to be used by the repository.
     * @return void
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Retrieves all records from the model, ordered by ID in descending order.
     *
     * @param int $limit The number of records to return per page.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function all($limit = 30)
    {
        return $this->model::query()
            ->orderBy('id', 'desc')
            ->paginate($limit);
    }

    /**
     * Retrieves all records from the model with a given condition.
     *
     * @param array $conditions The conditions to be applied to the query.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function where(array $conditions)
    {
        $query = $this->model::query();

        foreach ($conditions as $condition) {
            $query->where(
                $condition['column'],
                $condition['operator'],
                $condition['value']
            );
        }

        return $query;
    }
    /**
     * Retrieves a single record from the model by its ID.
     *
     * @param int $id The ID of the record to be retrieved.
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function find($id)
    {
        return $this->model::find($id);
    }

    /**
     * Creates a new record in the model.
     *
     * @param array $data The data to be used for creating the new record.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {

        return $this->model::create($data);
    }

    /**
     * Updates an existing record in the model by its ID.
     *
     * @param int $id The ID of the record to be updated.
     * @param array $data The data to be used for updating the record.
     * @return \Illuminate\Database\Eloquent\Model|null The updated record, or null if the record was not found.
     */
    public function update($id, array $data)
    {
        $mydata = $this->model::find($id);
        if ($mydata) {
            $mydata->update($data);
            return $mydata;
        }
        return null;
    }

    /**
     * Deletes a record from the model by its ID.
     *
     * @param int $id The ID of the record to be deleted.
     * @return int The number of records deleted.
     */
    public function delete($id)
    {
        return $this->model::destroy($id);
    }
    /**
     * Retrieves a record from the model by its slug.
     *
     * @param string $slug The slug of the record to be retrieved.
     * @return \Illuminate\Database\Eloquent\Model|null The retrieved record, or null if the record was not found.
     */
    public function findBySlug($slug)
    {
        return $this->model::query()->where('slug', $slug)->first();
    }
    /**
     * Deletes multiple records from the model by their IDs and also removes associated files.
     *
     * @param array $ids An array of IDs of the records to be deleted.
     * @return int The number of records deleted.
     */
    public function bulkDelete($ids)
    {
        foreach ($ids as $id) {
            $data = $this->find($id);
            if (file_exists($data->file_path)) {
                unlink($data->file_path);
            }
        }
        return $this->model::query()->whereIn('id', $ids)->delete();
    }
    /**
     * Retrieves a record from the model by a specified field and value.
     *
     * @param string $field The field name to search for.
     * @param mixed $value The value to search for in the specified field.
     * @return \Illuminate\Database\Eloquent\Model|null The retrieved record, or null if the record was not found.
     */
    public function findByField($field, $value)
    {
        return $this->model::query()->where($field, $value)->first();
    }

    /**
     * Creates a new record in the model or updates an existing one based on the specified field and value.
     *
     * @param string $field The field name to search for.
     * @param mixed $value The value to search for in the specified field.
     * @param array $data The data to be used for creating or updating the record.
     * @return \Illuminate\Database\Eloquent\Model The created or updated record.
     */
    public function createOrUpdateByField($field, $value, $data)
    {
        $data = $this->model::where($field, $value)->first();
        if ($data) {
            $data->update($data);
            return $data;
        }
        return $this->model->create($data);
    }

    public function createOrUpdateByCondition($condition, $data)
    {

        return $this->model::updateOrCreate($condition, $data);
    }
    /**
     * Retrieves data from the model based on various parameters.
     *
     * @param array|null $select The fields to be selected from the model.
     * @param string|null $search The search term to be applied to the model.
     * @param array|null $searchableFields The fields to be searched in the model.
     * @param string|null $filter The filter to be applied to the model.
     * @param string $sort The field to be used for sorting the data.
     * @param string $direction The direction of the sorting.
     * @param int|null $limit The maximum number of records to be retrieved.
     * @param int|null $paginate The number of records per page.
     * @param array|null $with The relationships to be eager loaded.
     * 
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function getData(
        $select = null,
        $search = null,
        $searchableFields = null,
        $filter = null,
        $sort = 'id',
        $direction = 'desc',
        $limit = null,
        $paginate = null,
        $with = null,

    ) {

        return $this->model::query()
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
            ->when($select, function ($query) use ($select) {
                return $query->select($select);
            })
            ->when($search, function ($query) use ($search, $searchableFields) {

                return $query->where(function ($query) use ($search, $searchableFields) {

                    foreach ($searchableFields as $field) {

                        $query->orWhere($field, 'like', '%' . $search . '%');
                    }

                    return $query;
                });
            })
            ->when($filter && $filter != 'all', function ($query) use ($filter) {

                return $query->where('status', $filter);
            })

            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->when($sort, function ($query) use ($sort, $direction) {
                return $query->orderBy($sort, $direction);
            })
            ->when($paginate, function ($query) use ($paginate) {
                return   $query->paginate($paginate)->appends(request()->all());
                // with request 
            });
    }

    /**
     * Searches the model for records where the specified field contains the given value.
     *
     * @param string $field The field to be searched in the model.
     * @param string $value The value to be searched for in the specified field.
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model[]
     */
    public function searchByField($field, $value, $select = null)
    {

        return $this->model::query()
            ->when($select, function ($query) use ($select) {

                return $query->select($select);
            })
            ->where($field, 'like', '%' . $value . '%')->get();
    }
}
