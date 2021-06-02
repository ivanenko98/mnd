<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'phone_number' => $this->phone_number,
            'master' => $this->master,
            'services' => ServiceResource::collection($this->services),
            'city' => $this->city,
            'status' => $this->status,
            'address' => $this->address,
            'total_cost' => $this->total_cost,
            'platform_fee' => $this->platform_fee,
            'comment' => $this->comment,
            'cancel_reason' => $this->cancel_reason,
            'created_at' => $this->created_at,
        ];
    }
}
