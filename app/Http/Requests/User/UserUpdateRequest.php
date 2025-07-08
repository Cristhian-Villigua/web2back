<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $userId = $this->route('id');
        return [
            'name' => 'required|max:250',
            'email' => 'required|max:250|unique:users,email,'.$userId,
            'password' => 'nullable|max:250|confirmed',
        ];
    }
}