<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'customer_id' => $this->customer_id,
            'total_prices' => $this->total_prices,
            'total_events' => $this->total_events,
            'users' => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}
