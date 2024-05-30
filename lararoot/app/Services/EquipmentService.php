<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Сервис для управления оборудованием.
 */
class EquipmentService
{
    /**
     * Создать новое оборудование.
     *
     * @param array $data Данные для создания нового оборудования.
     * @return Equipment Созданное оборудование.
     * @throws ValidationException Если валидация данных не проходит.
     *
     * Этот метод валидирует входные данные и создает новую запись оборудования в базе данных.
     */
    public function create(array $data): Equipment
    {
        $validator = Validator::make($data, [
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'serial_number' => 'required|string',
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return Equipment::create($data);
    }

    /**
     * Обновить существующее оборудование.
     *
     * @param Equipment $equipment Экземпляр оборудования для обновления.
     * @param array $data Данные для обновления оборудования.
     * @return Equipment Обновленное оборудование.
     * @throws ValidationException Если валидация данных не проходит.
     *
     * Этот метод валидирует входные данные и обновляет существующую запись оборудования в базе данных.
     */
    public function update(Equipment $equipment, array $data): Equipment
    {
        $validator = Validator::make($data, [
            'equipment_type_id' => 'sometimes|exists:equipment_types,id',
            'serial_number' => 'sometimes|string',
            'desc' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $equipment->update($data);
        return $equipment;
    }
}
