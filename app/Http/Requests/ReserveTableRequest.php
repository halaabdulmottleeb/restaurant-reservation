<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReserveTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'table_id' => 'required|exists:tables,id',
            'date' => 'required|date|after_or_equal:now',
            'capacity' => 'required|integer',
            'from_time' => 'required|date_format:H:i',
            'to_time' => 'required|date_format:H:i',
        ];
    }
}
