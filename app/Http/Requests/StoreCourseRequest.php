<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'required',
            'enabled'=>'boolean',
            'fee'=>'nullable|numeric',
            'start_date'=>'nullable|date',
            'end_date'=>'nullable|date',
            'closes_on'=>'nullable|date',
            'capacity'=>'nullable|integer',
            'payment_required'=>'boolean',
            'enforce_capacity'=>'boolean',
            'enforce_order'=>'boolean',
            'picture'=>'nullable|image'
        ];
    }
}
