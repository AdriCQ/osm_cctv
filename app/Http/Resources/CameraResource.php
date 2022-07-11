<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CameraResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'comments' => $this->comments,
            'ip' => $this->ip,
            'image' => $this->image,
            'model' => $this->model,
            'brand' => $this->brand,
            'dome' => $this->dome,
            'works' => $this->works,
            'position' => $this->position,
        ];
    }
}
