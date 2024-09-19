<?php

namespace App\Services;

class commonServices
{

    public function getData($model = null, $select = null, $condition = null, $limitflag = null, $request = null)
    {
        $daat = $model
            ->when($condition, function ($query) use ($condition) {
                return $query->where($condition);
            })
            ->when($select, function ($query) use ($select) {
                return $query->select($select);
            })
            ->when(@$request->order, function ($query) use ($request) {
                return $query->orderBy($request->order, $request->orderType);
            })
            ->when(@$request->pagination, function ($query) use ($request) {
                return $query->paginate($request->pagination)->appends($request->query());
            })
            ->when(($limitflag != null && !@$request->pagination), function ($query) use ($limitflag) {
              
                if ($limitflag  == -1) {
                    return $query->first();
                }
                return $query->get();
            });
           
        return $daat;
    }

    public function getSingleData($model = null, $select = null, $condition = null)
    {
        return $model
            ->when($condition, function ($query) use ($condition) {
                return $query->where($condition);
            })
            ->when($select, function ($query) use ($select) {
                return $query->select($select);
            })
            ->first();
    }
}
