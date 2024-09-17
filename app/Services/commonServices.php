<?php

namespace App\Services;

class commonServices
{

    public function getData($model = null, $select=null, $condition=null, $limitflag=null, $order=null, $orderType=null,$paginate =null, $with=null)
    {
        return $model
            ->when($with, function ($query) use ($with) {
                return $query->with($with);
            })
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
            ->when($paginate, function ($query) use ($paginate, $limitflag) {
                if($limitflag == -1){
                    return $query->paginate($paginate);
                }
                if ($limitflag == 1) {
                    return $query->first();
                }
                if ($limitflag == 0) {
                    return $query->get();
                }
                return $query->limit($paginate);
            })
            ->get();
    }
    
  
}
