<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Класс запроса для создания нового оборудования.
 */
class StoreEquipmentRequest extends FormRequest
{
    /**
     * Определить правила валидации для запроса.
     *
     * @return array Правила валидации.
     */
    public function rules(): array
    {
        return [
            'equipments' => 'required|array',
            /**
             * Поле `equipment_type_id` обязательно для заполнения и должно существовать в таблице `equipment_types` в колонке `id`.
             * Это гарантирует, что тип оборудования, который мы пытаемся присвоить новому оборудованию, уже существует в базе данных.
             */
            'equipments.*.equipment_type_id' => 'required|exists:equipment_types,id',

            /**
             * Поле `serial_number` обязательно для заполнения и должно быть строкой.
             * Оно также не должно превышать 255 символов, чтобы избежать проблем с хранением в базе данных.
             * Серийный номер необходим для уникальной идентификации каждого оборудования.
             */
            'equipments.*.serial_number' => 'required|string|max:255',

            /**
             * Поле `desc` является необязательным и должно быть строкой, если оно присутствует.
             * Это поле позволяет добавить дополнительное описание оборудования.
             * Максимальная длина описания ограничена 1000 символами для обеспечения целостности данных.
             */
            'equipments.*.desc' => 'nullable|string|max:1000',
        ];
    }
}
