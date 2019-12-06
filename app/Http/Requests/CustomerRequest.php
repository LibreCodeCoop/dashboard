<?php

namespace App\Http\Requests;

use App\Company;
use App\Customer;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CustomerRequest extends FormRequest
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
            'code' => ['required', Rule::unique((new Customer())->getTable())->ignore($this->route()->customer->id ?? null)],
            'cnpj' => [
                'required', Rule::unique((new Company())->getTable())->ignore($this->route()->customer->typeable_id ?? null)
            ],
            'social_reason' => 'required',
            'municipal_registration' => 'required',
            'state' => 'required',
            'phone' => 'required',
            'address' => 'required',
        ];
    }
}
