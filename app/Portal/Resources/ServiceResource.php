<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'value' => $this->id,
            'label' => $this->title,
        ];

        if ($this->children->count() > 0) {
            $data['children'] = ServiceResource::collection($this->children);
        }

        return $data;
    }
}
