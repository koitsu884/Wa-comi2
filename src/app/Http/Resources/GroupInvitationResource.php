<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GroupInvitationResource extends JsonResource
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
            'message' => $this->message,
            'status' => $this->status,
            'group_id' => $this->group_id,
            'group' => new GroupResource($this->whenLoaded('group')),
            'user_id' => $this->user_id,
            'user' => new UserResource($this->whenLoaded('user')),
            'invited_user_id' => $this->invited_user_id,
            'invited_user' => new UserResource($this->whenLoaded('invited_user')),
            'created_at' => (string) $this->created_at,
            'updated_at' => (string) $this->updated_at,
        ];
    }
}
