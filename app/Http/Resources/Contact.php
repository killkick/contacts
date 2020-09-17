<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Contact extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Requesct  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => [
                'contact_id' => $this->id,
                'name' => $this->name,
                'company' => $this->company,
                'birthday' => $this->birthday->format('d-m-Y'),
                'email' => $this->email,
                "last_update" => $this->updated_at->diffForHumans()
            ],
            'links' => [
                'path' => $this->path()
            ]
        ];
    }
}
