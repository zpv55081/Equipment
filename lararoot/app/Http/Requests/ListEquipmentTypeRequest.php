<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListEquipmentTypeRequest extends FormRequest
{
    /**
     * Правила валидации для получения списка типов оборудования
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'q' => 'nullable|string',
            'mask' => 'nullable|string',
            'name' => 'nullable|string',
        ];
    }
}
