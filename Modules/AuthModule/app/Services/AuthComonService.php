<?php

namespace Modules\AuthModule\Services;

class AuthComonService
{
    /**
     * Uploads an image to the specified path and generates a unique filename.
     *
     * @param object $image The image object to be uploaded
     * @param string $path The path where the image will be uploaded
     * @return string The path of the uploaded image
     */
    public function ImageUpload($image, $path)
    {

        // Generate a unique name for the file
        $fileName = uniqid('photo_') . '.' . $image->getClientOriginalExtension();

        // Move the file to the public/photos/products directory
        $image->move(public_path($path), $fileName);

        // Store the file path
        $imagePaths = $path . '/' . $fileName;

        return $imagePaths;
    }


    public function findByField($model = null, $field, $value)
    {
        return $model::query()->where($field, $value)->first();
    }
    public function create($model = null, $data)
    {
        return $model::create($data);
    }
    public function createOrUpdateByField($model = null, $condition, $data)
    {
        return $model::updateOrCreate($condition, $data);
    }

    public function getData($model = null, $select=null, $condition=null, $order=null, $orderType=null, $limit=null)
    {

        return $model
            ->when($condition, function ($query) use ($condition) {
                return $query->where($condition);
            })
            ->when($select, function ($query) use ($select) {
                return $query->select($select);
            })
            ->when($order, function ($query) use ($order, $orderType) {
                return $query->orderBy($order, $orderType);
            })
            ->when($order, function ($query) use ($order, $orderType) {
                return $query->orderBy($order, $orderType);
            })
            ->when($limit, function ($query) use ($limit) {
                return $query->limit($limit);
            })
            ->get();
    }
}
