<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGroupInvitation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $groupId = request()->route('group')->id;
        $requestUserId = (int)request()->user()->id;

        return [
            'invited_user_id' => [
                'required',
                'exists:users,id',
                'not_in:'.$requestUserId,
                Rule::unique('group_invitations',  'invited_user_id')->where(function ($query) use ($groupId){
                    return $query->where('group_id', $groupId);
                })
            ],
            'message' => 'nullable|max:1000',
        ];
    }
}
