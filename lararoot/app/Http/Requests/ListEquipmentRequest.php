<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListEquipmentRequest extends FormRequest
{
    /**
     * Правила валидации для получения списка оборудования
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'q' => 'nullable|string',
            'equipment_type_id' => 'nullable|exists:equipment_types,id',
        ];
    }
}
