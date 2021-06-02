<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceSelectedResource extends JsonResource
{
    public $ids = [];

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $this->collectIds($this);

        return $this->ids;
    }

    function collectIds($service)
    {
        array_unshift($this->ids, $service->id);

        if ($service->parent_id !== null) {
            $this->collectIds($service->parent);
        }
    }
}
