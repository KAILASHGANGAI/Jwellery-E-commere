<?php

namespace Modules\Admin\Services;

class AdminComonService
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
    // public function ImageDelete($path){
    //     if ($request->hasFile('images')) {
    //         $Images = Image::where('product_id', $product->id)->get();
    //         foreach ($Images as $img) {
    //             if (file_exists($img->image)) {
    //                 unlink($img->image);
    //                 $img->delete();
    //             }
    //         }

    //         foreach ($request->file('images') as $key => $image) {

    //             // Generate a unique name for the file
    //             $fileName = uniqid('photo_') . '.' . $image->getClientOriginalExtension();

    //             // Move the file to the public/photos/products directory
    //             $image->move(public_path('photos/products'), $fileName);

    //             // Store the file path
    //             $imagePaths = '/photos/products/' . $fileName;
    //             if ($key == 0) {
    //                 $product->update(['image' => $imagePaths]);
    //             }
    //             Image::create([
    //                 'product_id' => $product->id,
    //                 'pendingProcess' => 1,
    //                 'mainImage' => ($key == 0) ? 1 : 0,
    //                 'image' => $imagePaths,
    //                 'imageSequence' => $key,
    //                 'fullUrl' => env('APP_URL') . $imagePaths,
    //                 'status' => 1
    //             ]);
    //         }
    //     }
    // }
}
