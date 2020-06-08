<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
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
            'title' => $this->title,
            'content' => $this->content,
            'main_image' => $this->main_image,
            'main_image_thumb' => $this->main_image_thumb,
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
            'post_category_id' => (string) $this->post_category_id,
            'category' => new PostCategoryResource($this->whenLoaded('category')),
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'area_id' => $this->area_id,
            'area' => new AreaResource($this->whenLoaded('area')),
        ];
    }
}
