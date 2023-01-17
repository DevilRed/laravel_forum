<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ThreadRequest extends FormRequest
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
            'title' =>'required',
            'body' => 'required',
            // validate given value is present on channels table,  https://laravel.com/docs/9.x/validation#rule-exists
            'channel_id' => 'required|exists:channels,id',
        ];
    }
}
