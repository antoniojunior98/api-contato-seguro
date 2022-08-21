<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class UserRequest extends FormRequest
{
    protected $update;
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(Request $request)
    {
        $this->update = $request->user ? true : false;
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
                'name' => 'required|string',
                'email' => 'required|email',
                'telephone' => 'telephone',
                'birthday' => 'date',
                'city' => 'check_city',
                'companies' => 'required|check_companies'
            ];
    }
}
