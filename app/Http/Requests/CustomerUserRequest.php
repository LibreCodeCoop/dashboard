<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CustomerUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'code' => 'required',
            'cpf' => [
                'required', Rule::unique((new User)->getTable())->ignore($this->route()->customer->typeable_id ?? null)
            ],
            'name' => [
                'required', 'min:3'
            ],
            'email' => [
                'required', 'email', Rule::unique((new User)->getTable())->ignore($this->route()->customer->typeable_id ?? null)
            ],
            'password' => [
                $this->route()->customer ? 'nullable' : 'required', 'min:6'
            ],
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}
