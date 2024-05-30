<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс запроса для обновления существующего оборудования.
 */
class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Определить правила валидации для запроса.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            /**
             * Поле `equipment_type_id` является необязательным и должно существовать в таблице `equipment_types` в колонке `id`, если оно присутствует.
             * Это гарантирует, что тип оборудования, который мы пытаемся присвоить обновляемому оборудованию, уже существует в базе данных.
             */
            'equipment_type_id' => 'sometimes|exists:equipment_types,id',

            /**
             * Поле `serial_number` является необязательным и должно быть строкой, если оно присутствует.
             * Серийный номер необходим для уникальной идентификации каждого оборудования.
             */
            'serial_number' => 'sometimes|string',

            /**
             * Поле `desc` является необязательным и должно быть строкой, если оно присутствует.
             * Это поле позволяет добавить или обновить дополнительное описание оборудования.
             */
            'desc' => 'nullable|string',
        ];
    }
}
