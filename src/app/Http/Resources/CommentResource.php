<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
      //  return parent::toArray($request);
        return [
            'id' => $this->id,
            'comment' => $this->comment,
            'user' => new UserResource($this->whenLoaded('user')),
            'replies_count' => $this->replies_count,
            'replies' => ReplyResource::collection($this->whenLoaded('replies')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
