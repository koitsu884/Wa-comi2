<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupResource extends JsonResource
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
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'area_id' => $this->area_id,
            'area' => new AreaResource($this->whenLoaded('area')),
            'group_category_id' => (string) $this->group_category_id,
            'category' => new GroupCategoryResource($this->whenLoaded('category')),
            'name' => $this->name,
            'is_public' => $this->is_public,
            'description' => $this->description,
            'homepage' => $this->homepage,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'main_image' => $this->main_image,
            'main_image_thumb' => $this->main_image_thumb,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
