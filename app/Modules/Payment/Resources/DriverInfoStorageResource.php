<?php

namespace App\Modules\Payment\Resources;

use App\Modules\Payment\Models\DriverInfoStorage;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverInfoStorageResource extends JsonResource
{

    // protected $collection;

    // public function __construct($resource)
    // {
    //     parent::__construct($resource);
    //     dd($resource);
    // }

    public function toArray(Request $request): array
    {
        $array = $this->convertArray();
        return $array;
    }

    public function convertArray() : array
    {
        $models = $this->resource;
        {
            $akkum = [];
            foreach($models as $model){
                $akkum[$model->type_name->value][] = $model->parametr_name->value;
            }
        }

        return $akkum;
    }
}
